<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('username', $request->username)->with('education','experience','skills','projects')->first();
        if (empty($user)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "User not found",
                'user' => $request->username
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User retrieved successfully",
            'user' => $user
        ], Response::HTTP_ACCEPTED);
    }
}
