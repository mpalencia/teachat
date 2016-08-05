<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class CurriculumRequest extends Request
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

        if (is_null($this->curriculum_id)) {

            return [
                'grade_id' => "required",
                'subject_category_id' => "required",
                'subject' => "required|unique:curriculum",
            ];
        }

        return [
            'grade_id' => "required",
            'subject_category_id' => "required",
            'subject' => "required|unique:curriculum,subject,{$this->curriculum_id}",
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
            'subject_category_id.required' => 'The subject category field is required.',
            'subject_category_id.unique' => 'The subject category has been already taken.',
            'subject.required' => 'The subject field is required.',
            'subject.unique' => 'Subject is aleady in the list.',
        ];
    }
}
