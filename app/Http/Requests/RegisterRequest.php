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
        $rules = [
            'role_id' => 'required',
            'gender' => 'required',
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address_one' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'contact_cell' => 'required|numeric',
            'contact_home' => 'numeric',
            'contact_work' => 'numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'agree' => 'required',
        ];

        if (!is_null($this->user_id)) {
            $rules = [
                'gender' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'address_one' => 'required',
                'state_id' => 'required',

                'city' => 'required',
                'contact_cell' => 'required',
                'email' => 'required|email|unique:users,email,' . $this->user_id,
            ];
        }

        if ($this->country_id == 1) {
            $rules['zip_code'] = 'required';
        }

        if ($this->role_id == 2) {
            $rules['school_id'] = 'required';
        }

        if ($this->role_id == 4 || $this->role_id == 1) {

            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'school_id' => 'required',
                'state_id' => 'required',
                'country_id' => 'required',
            ];

            if ($this->user_id != null) {
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $this->user_id,
                    'school_id' => 'required',
                    'state_id' => 'required',
                    'country_id' => 'required',
                ];
            }
        }

        if ($this->role_id == 3 || $this->role_id == 2) {

            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'address_one' => 'required',
                'state_id' => 'required',
                'city' => 'required',
                'contact_cell' => 'required|numeric',
                'contact_home' => 'numeric',
                'contact_work' => 'numeric',
                
            ];

            if ($this->country_id == 1) {
                $rules['zip_code'] = 'required';
            }

        }

        return $rules;
    }
}
