<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "task_name"=> 'required|string|max:255|min:3',
            "task_description"=> 'required|string|max:1000|min:10',
            "task_theme"=> 'string|nullable',

            "task_estimated_price"=> 'numeric',
            "task_start_date"=> 'date|nullable',
            "task_due_date"=> 'date|nullable',
            "task_done"=> 'nullable|boolean',

            "company_id"=>"numeric",
            "user_id"=>"numeric",
            "project_id"=>"numeric|nullable",
            'task_priority' => 1,
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'task_done' => false,
            'task_priority' => 1,
            'company_id' => auth()->user()->company->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
