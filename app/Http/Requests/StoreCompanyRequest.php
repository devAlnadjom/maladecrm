<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => "string|required|min:3|max:200",
            'address'=>"required|max:255",
            'categorie'=>"required|max:255",
            'contact'=>"required|max:20",
            'description' =>"max:5000",
            'owner_id' =>"numeric"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vous devez fournir un nom...',
            'name.min' => 'Le nom de l\'entreprise doit contenir au moins 3 caracteres.',
            'address.required' => 'Vous devez fournir une adresse...',
            'contact.required' => 'Vous devez fournir un contact...',
            'categorie.required' => 'Vous devez fournir un votre secteur d\'activite...',
            // ..
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'owner_id' => auth()->user()->id,
        ]);
    }
}
