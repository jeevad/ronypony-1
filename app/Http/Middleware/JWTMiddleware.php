<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Http\Responses\UnauthenticatedResponse;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return new UnauthenticatedResponse('Token is Invalid');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return new UnauthenticatedResponse('Token is Expired');
            } else {
                return new UnauthenticatedResponse('Authorization Token not found');
            }
        }
        return $next($request);
    }
}