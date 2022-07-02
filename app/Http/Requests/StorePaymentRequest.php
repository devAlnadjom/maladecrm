<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            "customer_id"=> "numeric",
            "company_id"=>"numeric",
            "user_id"=>"numeric",
            "order_id"=>"string",
            "montant"=>"numeric",

            "method"=>"string|required|max:100",
            "description"=>"max:200",
            "date"=>"date",

        ];
    }

    public function messages()
    {
        return [
            'customer_id.numeric' => 'Veuillez selectionner un client',
            'montant.numeric' => 'Veuillez saisir un montant',
            'method.*' => 'Veuillez saisir une methode paiement',
            'date.date' => 'Veuillez selectionner la date de paiement ',

            // ..
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            //'order_key' => sha1(time()),
            'company_id' => auth()->user()->company->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}



