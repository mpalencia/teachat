<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class AccountRequest extends Request
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
                'title' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'address_one' => 'required',
                'state_id' => 'required',
                'city' => 'required',
                'contact_cell' => 'required|numeric',
                'contact_home' => 'numeric',
                'contact_work' => 'numeric',
                
            ];
    }

     /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contact_cell.numeric' => 'The Contact Number field must be a number.',
            'contact_home.numeric' => 'The Contact Number(Home) field must be a number.',
            'contact_work.numeric' => 'The Contact Number(Work) field must be a number.',
        ];
    }
}
