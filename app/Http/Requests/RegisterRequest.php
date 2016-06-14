<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class RegisterRequest extends Request
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
            'role_id' => 'required',
            'gender' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'address_one' => 'required',
            'state_id' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'school_id' => 'required',
            'contact_mobile' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'agree' => 'required',
        ];
    }
}
