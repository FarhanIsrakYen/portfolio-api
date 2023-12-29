<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::with('roles')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Users retrieved successfully",
            'user' => $users
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $createUserRequest): JsonResponse
    {
        $user = User::create([
            'name' => $createUserRequest->name,
            'email' => $createUserRequest->email,
            'password' => bcrypt($createUserRequest->password),
            'roles' => json_encode(['ROLE_USER']),
            'phone' => $createUserRequest->phone,
            'address' => $createUserRequest->address,
            'website' => $createUserRequest->website,
            'dob' => $createUserRequest->dob,
            'objective' => $createUserRequest->objective,
            'interests' => $createUserRequest->interests,
            'isActive' => $createUserRequest->isActive ?? true
        ]);
        $user->assignRole($createUserRequest->roles);
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User created successfully",
            'user' => $user
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
