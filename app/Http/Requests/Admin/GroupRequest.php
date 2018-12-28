<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
        $rules = [
            'discount' => 'required',
            'discount_type' => 'required|in:FIXED,PERCENTAGE'
        ];
        if ($this->getMethod() === 'POST') {
            $rules['name'] = 'required|max:255|alpha_dash|unique:user_groups';
        }
        if ($this->getMethod() === 'PUT') {
            $rules['name'] = [
                'required', 'max:255', 'alpha_dash', Rule::unique('user_groups')
                    ->ignore($this->route('user_group')->id),
            ];
        }
        return $rules;
    }
}
