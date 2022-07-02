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
            'name' => "required|min:3|max:200",
            'address'=>"required|max:255",
            'country'=>"string|max:255",
            'telephone'=>"required|max:20",
            'contact'=>"max:20",
            'fiscal_code'=>"max:255",
            'email'=>"email|max:255",
            'solde' =>"integer",
            'description' =>"max:5000",
            'company_id' =>"numeric"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vous devez fournir un Nom...',
            'name.min' => 'Le nom du client doit contenir au moins 3 caracteres.',
            'address.required' => 'Veuillez fournir une adresse.',
            'telephone.required' => 'Veuillez fournir un numero de telephone.',
            'telephone.max' => 'Le numero de tephone doit etre inferieur a 20 Charactere.',
            'solde.integer' => 'Le solde doit etre une valeur numerique.',
            'email.email' => 'Veuillez fournir une adresse mail valide',
            // ..
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'company_id' => auth()->user()->company->id,
        ]);
    }
}
