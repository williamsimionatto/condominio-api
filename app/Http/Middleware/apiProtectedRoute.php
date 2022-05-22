<?php
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtectedRoute extends BaseMiddleware {
    public function handle($request, Closure $next) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response(['message'=>'Token inválido!'], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response(['message'=>'Token expirado!'], 401);
            } else {
                return response(['message'=>'Token de autorização não informado!'], 401);
            }
        }

        return $next($request);
    }
}