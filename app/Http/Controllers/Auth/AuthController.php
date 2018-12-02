<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\AuthLoginResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Responses\ServerErrorResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return new UnauthenticatedResponse(trans('alerts.unauthenticated'));
            }
        } catch (JWTException $e) {
            return new ServerErrorResponse(trans('auth.could_not_create_token'));
        }

        return new AuthLoginResponse($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = auth('api')->userOrFail();
            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return new ServerErrorResponse('Failed to get user.');
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth('api')->logout();
            return new SuccessResponse('Successfully logged out.');
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return new ServerErrorResponse('Failed to logout, please try again.');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return new AuthLoginResponse(auth('api')->refresh());
        } catch (JWTException $e) {
            return new ServerErrorResponse('Failed to refresh the token.');
        }
    }
}