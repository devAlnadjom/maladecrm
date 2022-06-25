<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true; //
    }

    public function rules()
    {
        return [
            'name' => "string|required|max:200",
            'address'=>"string|required|max:255",
            'country'=>"string|max:255",
            'telephone'=>"max:20",
            'contact'=>"max:20",
            'fiscal_code'=>"max:255",
            'email'=>"email|required|max:255",
            //'solde' =>"integer",
            'description' =>"max:5000"
        ];
    }
}
