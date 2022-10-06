<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "activity_name"=> 'required|string|max:255|min:3', //

            "activity_description"=> 'required|string|max:1000|min:10',//
            "activity_theme"=> 'string|nullable',//
            "activity_priority"=> 'numeric|nullable',//
            "activity_estimated_price"=> 'numeric',//
            "activity_start_date"=> 'date|nullable',//
            "activity_due_date"=> 'date|nullable',//
            "activity_done"=> 'numeric',//

            "company_id"=>"numeric",//
            "user_id"=>"numeric",//
            "project_id"=>"numeric|nullable",//
            "task_id"=>"numeric|nullable",//
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'company_id' => auth()->user()->company->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
