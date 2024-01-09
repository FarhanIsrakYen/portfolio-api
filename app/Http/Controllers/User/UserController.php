<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User retrieved successfully",
            'user' => $user
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $updateUserRequest)
    {
        $user = Auth::user();
        $user->update([
            'name' => empty($updateUserRequest->name)? $user->name : $updateUserRequest->name,
            'email' => empty($updateUserRequest->email)? $user->email : $updateUserRequest->email,
            'password' => empty($updateUserRequest->password)? $user->password : $updateUserRequest->password,
            'phone' => empty($updateUserRequest->phone)? $user->phone : $updateUserRequest->phone,
            'address' => empty($updateUserRequest->address)? $user->address : $updateUserRequest->address,
            'website' => empty($updateUserRequest->website)? $user->website : $updateUserRequest->website,
            'dob' => empty($updateUserRequest->dob)? $user->dob : $updateUserRequest->dob,
            'objective' => empty($updateUserRequest->objective)? $user->objective : $updateUserRequest->objective,
            'interests' => empty($updateUserRequest->interests)? $user->interests : $updateUserRequest->interests,
        ]);
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User updated successfully",
            'user' => Auth::user()
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updatePassword(UpdatePasswordRequest $updatePasswordRequest)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($updatePasswordRequest->confirmPassword),
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Password updated successfully",
            'user' => Auth::user()
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deactivateAccount()
    {
        $user = Auth::user();

        $user->update([
            'is_active' => 0
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Account deactivated successfully",
            'user' => Auth::user()
        ], Response::HTTP_ACCEPTED);
    }
}
