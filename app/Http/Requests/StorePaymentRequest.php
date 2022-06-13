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

            "method"=>"string|max:100",
            "description"=>"string|max:200",
            "date"=>"date",

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



