<?php

namespace App\Http\Requests;

use App\Helpers\AddressBag;
use App\Rules\ValidateCity;
use App\Rules\ValidateZIPCode;
use App\Rules\ValidateLastName;
use App\Rules\ValidateLocality;
use App\Rules\ValidateFirstName;
use App\Rules\ValidateOfficeName;
use Illuminate\Foundation\Http\FormRequest as Request;

class AddressRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isMethod('POST')) {
            return true;
        }
        $address = $this->route('address');
        return $address && (int)$this->user('api')->id === (int)$address->user_id;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', new ValidateFirstName, 'min:3', 'max:50'],
            'last_name' => ['required', new ValidateLastName, 'min:1', 'max:50'],
            'office_name' => ['sometimes', new ValidateOfficeName, 'min:3', 'max:50'],
            'email' => 'sometimes|max:255|email',
            'phone_number' => 'sometimes|max:20',
            'locality' => ['required', new ValidateLocality, 'min:3', 'max:100'],
            'address' => ['required', 'min:10', 'max:250'],
            'landmark' => 'sometimes|max:255',
            'city' => ['required', 'min:3', 'max:100', new ValidateCity,],
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'zip_code' => ['required', new ValidateZIPCode],
            'default' => 'sometimes|in:true,false',
        ];
    }

    public function toBag(): AddressBag
    {
        return new AddressBag($this->validated());
    }
}
