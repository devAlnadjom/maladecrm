<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => "string|required|max:200",
            'address'=>"string|required|max:255",
            'country'=>"string|max:255",
            'telephone'=>"string|max:20",
            'contact'=>"string|max:20",
            'fiscal_code'=>"string|required|max:255",
            'email'=>"email|required|max:255",
            'solde' =>"integer",
            'description' =>"max:5000"
        ];
    }
}
