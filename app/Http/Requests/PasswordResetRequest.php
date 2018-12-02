<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('banned', 0);
                }),
            ],
            'password' => 'required|confirmed|min:6|max:25',
            'password_confirmation' => 'required',
        ];
    }
}
