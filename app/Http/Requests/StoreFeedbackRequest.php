<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type'=>'string|required',
            'comment'=>'string|required|max:1000',
        ];
    }

    public function messages()
{
    return [
        'type.required' => 'A title is required',
        'comment.required' => 'A message is required',
    ];
}
}
