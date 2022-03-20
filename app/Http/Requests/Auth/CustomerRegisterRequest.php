<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            'name' => 'string|required|min:2|max:32',
            'gender' => 'string',
            'bday' => 'string',
            'email' => 'string|required|email|min:3|max:100',
            'password' => 'string|required|min:8|max:16',
            'address' => 'required',
            'address.address' => 'string|required',
            'address.barangay' => 'string|required',
            'address.city' => 'string|required',
            'address.zip_code' => 'string|required',
            'address.contact_number' => 'string|required',
            'address.region' => 'string|required',
        ];
    }
}
