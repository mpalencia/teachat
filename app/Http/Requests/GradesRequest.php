<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class GradesRequest extends Request
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
        if (is_null($this->grade_id)) {
            return [
                'description' => "required|max:50", /*|unique:grades*/
            ];
        }

        return [
            'description' => "required|max:50", /*|unique:grades,description,{$this->grade_id}*/
        ];
    }
}
