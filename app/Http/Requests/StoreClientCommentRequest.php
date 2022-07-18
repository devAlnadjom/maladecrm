<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientCommentRequest extends FormRequest
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
            'type' => "required|min:3|max:200",
            'comment'=>"required|min:3|max:255",
            'company_id' =>"numeric",
            'user_id' =>"numeric",
            'customer_id' =>"numeric"
        ];
    }

    public function messages()
    {
        return [
            'type.*' => 'Veuillez Selectionner un type',
            'comment.min' => 'Le Commentaire doit contenir au moins 3 caracteres.',
            'comment.required' => 'Vous devez fournir un commentaire.',

            // ..
        ];
    }


    protected function prepareForValidation(){
        $this->merge([
            'company_id' => auth()->user()->company->id,
            'user_id'=> auth()->id(),
        ]);
    }
}
