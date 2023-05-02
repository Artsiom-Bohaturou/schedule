<?php

namespace App\Http\Requests\Admin\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GroupStoreRequest extends FormRequest
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
            'name' => 'string|required',
            'education_type_id' => 'exists:group_education_types,id|required|integer',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date_start' => date('Y-m-d', strtotime($this->date_start)),
            'date_end' => date('Y-m-d', strtotime($this->date_end)),
        ]);
    }
}
