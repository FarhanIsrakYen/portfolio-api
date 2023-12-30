<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

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
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deactivate()
    {

    }
}
