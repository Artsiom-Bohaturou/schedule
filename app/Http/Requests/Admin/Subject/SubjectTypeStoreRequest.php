<?php

namespace App\Http\Requests\Admin\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubjectTypeStoreRequest extends FormRequest
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
            'abbreviated_name' => 'required|string',
            'full_name' => 'required|string',
            'exam' => 'boolean|nullable',
            'long' => 'boolean|nullable',
        ];
    }
}
