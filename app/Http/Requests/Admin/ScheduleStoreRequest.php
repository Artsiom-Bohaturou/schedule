<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ScheduleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group_id' => 'exists:groups,id|required',
            'teacher_id' => 'exists:teachers,id|required',
            'subject_id' => 'exists:subjects,id|required',
            'subject_type_id' => 'exists:subject_types,id|required',
            'building' => 'required',
            'auditory' => 'integer|required',

            'subject_time_id' => 'exists:subject_times,id|required_without:date',
            'long' => 'nullable',
            'week_numbers' => 'required_without:date|array',
            'weekdays' => 'array|required_without:date',
            'subgroup' => 'required_without:date',
            'date_start' => 'required_without:date',
            'date_end' => 'required_without:date',

            'date' => 'required_without:subject_time_id,week_numbers,weekdays,subgroup,date_start,date_end',

        ];
    }

    protected function prepareForValidation()
    {
        if (is_null($this->date)) {
            $this->merge([
                'date_start' => date('Y-m-d', strtotime($this->date_start)),
                'date_end' => date('Y-m-d', strtotime($this->date_end)),
            ]);
        } else {
            $this->merge([
                'date' => date('Y-m-d H:i', strtotime($this->date)),
                'date_start' => null,
                'date_end' => null,
            ]);
        }

    }
}
