<?php

namespace App\Http\Controllers;

use Hash;
use JWTAuth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Http\Resources\ProfileResource;
use App\Http\Responses\AuthLoginResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfilesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email'),
            'sign_up_ip' => $request->ip(),
            'sign_up_user_agent' => $request->userAgent(),
            'password' => Hash::make($request->get('password')),
            'email_activation_token' => User::generateActivationToken(),
        ]);
        event(new UserRegistered($user));

        $token = JWTAuth::fromUser($user);

        return new AuthLoginResponse($token);
    }

    public function show(User $user)
    {
        echo $user->id;
        if (!$user) {
            throw new ModelNotFoundException;
        }
        return new ProfileResource($user);
    }
}
