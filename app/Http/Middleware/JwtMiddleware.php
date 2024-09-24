<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $privateKey = env('JWT_SECRET','EFNsn92UCYn1MF857bA3qOAcqNU7XUIxmyoysZuPbLhJwB3DLL3tDVvkYfiXGu07');
            $token = $request->bearerToken();
            if($token == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authorization token required'
                ],401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }

        return $next($request);
    }
}
