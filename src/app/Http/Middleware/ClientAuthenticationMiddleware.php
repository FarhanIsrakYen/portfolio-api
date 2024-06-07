<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ClientAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            DB::table('users')->where([
                ['secret_key', '=', $request->header('Auth-Token')],
                ['is_active', '=', true],
            ])->doesntExist()
        ) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => "Not an authenticated user",
                'data' => []
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
