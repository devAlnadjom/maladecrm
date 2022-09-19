<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "project_name"=> 'required|string|max:255|min:3', //
            "project_category"=> 'string',//
            "project_description"=> 'required|string|max:1000|min:10',
            "project_theme"=> 'string',
            "project_estimated_price"=> 'numeric',
            "project_start_date"=> 'date|nullable',
            "project_end_date"=> 'date|nullable',
            "project_template_id"=> 'numeric',
            "customer_id"=> 'numeric|nullable',

            "company_id"=>"numeric",
            "user_id"=>"numeric",
            "project_status"=>"numeric",
            "project_public_key"=>"string",
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'project_template_id' => 1,
            'project_public_key' => sha1(time()),
            'project_status' => 1,
            'company_id' => auth()->user()->company->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
