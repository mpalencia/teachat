<?php

namespace Teachat\Http\Requests;

use Teachat\Http\Requests\Request;

class AppointmentsRequest extends Request
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
            //'parent_id' => 'required',
            'appt_date' => 'required',
            'appt_stime' => 'required',
            'appt_etime' => 'required',
            'title' => 'required',
            'description' => 'required',
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
            //'parent_id.required' => 'The parent field is required.',
            'appt_date.required' => 'The appointment date field is required.',
            'appt_stime.required' => 'The appointment start date field is required.',
            'appt_etime.required' => 'The appointment end date field is required.',
        ];
    }
}
