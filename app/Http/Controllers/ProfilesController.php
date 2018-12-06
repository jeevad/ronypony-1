<?php

namespace App\Http\Controllers;

use Hash;
use Storage;
use JWTAuth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Http\Responses\SuccessResponse;
use App\Http\Resources\ProfileResource;
use App\Http\Responses\AuthLoginResponse;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Responses\UnauthorizedResponse;
use App\Http\Requests\UploadUserImageRequest;
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
        if (!$user) {
            throw new ModelNotFoundException;
        }
        return new ProfileResource($user);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user('api');
        $user->update($request->validated());

        return ((new ProfileResource($user))
            ->additional(['message' => trans('notifications.profile_update_success')]));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = $request->user('api');
        if ($user->authenticatePassword($request->get('current_password'))) {
            $user->updatePassword($request->get('password'));

            return new SuccessResponse(trans('passwords.reset'));
        }

        return new UnauthorizedResponse('Your Current Password Wrong!');
    }

    public function updateAvatar(UploadUserImageRequest $request)
    {
        $user = $request->user('api');
        $file = $request->file('avatar');
        $avatarName = generate_file_name($file->getClientOriginalExtension());
        Storage::disk('public')
            ->putFileAs($user->avatarFolder(), $file, $avatarName);

        $user->updateAvatar($avatarName);

        return ((new ProfileResource($user))
            ->additional(['message' => trans('notifications.avatar_update_success')]));
    }
}
