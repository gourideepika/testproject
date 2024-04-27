<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'due_date' => 'required',
            'priority_level' => 'required',
            'description'  => 'required',
            'title'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'due_date.required' => 'The Due Date field is required.',
            'priority_level.required' => 'The Priority Level field is required.',
            'description.required'=> 'The Description field is required.',
            'title.required'=> 'The Title field is required.',
        ];
    }
}
