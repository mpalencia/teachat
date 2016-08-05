<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class ChangePasswordRequest extends Request
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
            'current_pass' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        return $rules;
    }

}
