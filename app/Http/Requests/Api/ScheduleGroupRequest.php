<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleGroupRequest extends FormRequest
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
            'weekdays' => 'required|array',
            'subgroup' => 'sometimes|in:1,2',
            'type' => 'sometimes|exists:subject_types,abbreviated_name',
            'weeks' => 'sometimes|in:1,2,3,4|array',
            'group' => 'required',
        ];
    }
}
