<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTMiddleware
{
    public function handle($request, Closure $next, $role = null)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'meta' => [
                        'success' => false,
                        'errors' => ['Invalid token'],
                    ],
                ], 401);
            }

            if ($role && $user->role !== $role) {
                return response()->json([
                    'meta' => [
                        'success' => false,
                        'errors' => ['Unauthorized: Insufficient role permissions'],
                    ],
                ], 403);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token expired'],
                ],
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token not provided or invalid'],
                ],
            ], 401);
        }

        return $next($request);
    }
}
