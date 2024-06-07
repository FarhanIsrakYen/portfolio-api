<?php

namespace App\Http\Controllers;

use App\Http\Helpers\EncryptionHelper;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Summary of AuthController
 */
class AuthController extends Controller
{
    private const USER_ROLE = 'ROLE_USER';

    /**
     * Summary of login
     * @param LoginUserRequest $loginUserRequest
     * @return Response
     */
    public function login(LoginUserRequest $loginUserRequest) : Response {
        $user = User::firstWhere('email', $loginUserRequest->email);
        if (empty($user)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "No email found. Please sign up first to continue",
                'user' => $loginUserRequest->email
            ], Response::HTTP_NOT_FOUND);
        }
        if (!$user->is_active) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => "Account was deactivated! Please request for account reactivation",
                'user' => $loginUserRequest->email
            ], Response::HTTP_UNAUTHORIZED);
        }

        $credentials = $loginUserRequest->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Authentication failed! Please try again!',
                'data' => []
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $token,
            'status' => Response::HTTP_OK,
            'message' => 'Logged in successfully',
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Summary of register
     * @param CreateUserRequest $createUserRequest
     * @return Response
     */
    public function register(CreateUserRequest $createUserRequest) : Response {
        $user = User::create([
            'name' => $createUserRequest->name,
            'email' => $createUserRequest->email,
            'username' => $createUserRequest->username,
            'password' => bcrypt($createUserRequest->password),
            'roles' => json_encode([self::USER_ROLE]),
            'phone' => $createUserRequest->phone,
            'address' => $createUserRequest->address,
            'website' => $createUserRequest->website,
            'dob' => $createUserRequest->dob,
            'objective' => $createUserRequest->objective,
            'interests' => $createUserRequest->interests,
            'is_active' => true,
            'secret_key' => EncryptionHelper::generateKey(80)
        ]);
        $user->syncRoles(['user']);
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Signed up successfully",
            'user' => new UserResource($user)
        ], Response::HTTP_ACCEPTED);
    }
}
