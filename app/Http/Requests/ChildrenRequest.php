<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class ChildrenRequest extends Request
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
            'first_name' => 'required|max:50',
            'middle_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'birthdate' => 'required',
            'grade_id' => 'required',
            'state_id' => 'required',
            'gender' => 'required',
            'city' => 'required',
            'section' => 'required',
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
            'grade_id.required' => 'The grade field is required.',
            'state_id.required' => 'The state field is required.',
        ];
    }
}
