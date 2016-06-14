<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class SubjectCategoryRequest extends Request
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
        if (is_null($this->subject_category_id)) {
            return [
                'description' => "required|max:50", /*|unique:subject_category*/
            ];
        }

        return [
            'description' => "required|max:50", /*|unique:subject_category,description,{$this->subject_category_id}*/
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
            'description.required' => 'The subject category field is required.',
            //'description.unique' => 'The subject category has already been taken.',
        ];
    }
}
