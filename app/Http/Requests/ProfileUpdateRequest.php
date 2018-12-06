<?php

namespace App\Http\Requests;

use App\Rules\SpamFree;
use App\Rules\ValidateFullName;
use Illuminate\Validation\Rule;
use App\Rules\ValidateMobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $userId = $this->user('api')->id;
        return [
            'full_name' => ['required', 'min:3', 'max:100', new ValidateFullName, new SpamFree,],
            'email' => [
                'required', 'email', 'max:255', Rule::unique('users')->ignore($userId),
            ],
            'mobile_number' => [
                'required', new ValidateMobileNumber,
                Rule::unique('users')->ignore($userId),
            ],
        ];
    }
}
