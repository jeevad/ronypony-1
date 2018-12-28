<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $rules = ['name' => 'required|max:255'];
        if ($this->getMethod() === 'POST') {
            $rules['slug'] = 'required|max:255|alpha_dash|unique:roles';
        }
        if ($this->getMethod() === 'PUT') {
            $rules['slug'] = [
                'required', 'max:255', 'alpha_dash', Rule::unique('roles')
                    ->ignore($this->route('role')->id),
            ];
        }


        return $rules;
    }
}
