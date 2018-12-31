<?php

namespace App\Http\Requests\Admin;

use App\Rules\SpamFree;
use App\Rules\ValidateFullName;
use Illuminate\Validation\Rule;
use App\Rules\ValidateMobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [];
        $rules['full_name'] = ['required', 'min:3', 'max:100', new ValidateFullName, new SpamFree,];
        $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users'),];
        $rules['mobile_number'] = ['required', new ValidateMobileNumber, Rule::unique('users'),];
        $rules['role_id'] = ['required', Rule::exists('roles', 'id'),];
        $rules['group_id'] = ['required', Rule::exists('user_groups', 'id'),];

        if ($this->getMethod() == 'PUT') {
            $userId = $this->route('user')->id;
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId),];
            $rules['mobile_number'] = ['required', new ValidateMobileNumber, Rule::unique('users')->ignore($userId),];
        }

        return $rules;
    }
}
