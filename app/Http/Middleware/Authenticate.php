<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return null;
    }

    protected function unauthenticated($request, array $guards)
    {
        try {
            // Intenta autenticar usando el token
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'meta' => [
                        'success' => false,
                        'errors' => ['Invalid token'],
                    ],
                ], 401);
            }

            // Token válido, la autenticación fue exitosa.
            return response()->json([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => [] // Aquí puedes devolver la información que desees.
            ], 200);

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
    }
}
