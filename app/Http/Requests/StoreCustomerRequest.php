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
            'telephone'=>"max:20",
            'contact'=>"max:20",
            'fiscal_code'=>"max:255",
            'email'=>"email|max:255",
            'solde' =>"integer",
            'description' =>"max:5000",
            'company_id' =>"numeric"
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'company_id' => auth()->user()->company->id,
        ]);
    }
}
