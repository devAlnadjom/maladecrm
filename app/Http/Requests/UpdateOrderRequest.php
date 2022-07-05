<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            "id"=>"numeric",
            "customer_id"=> "numeric",

           "order_status"=> "numeric",
           "order_key"=>"max:100",

            "ref_customer"=>"max:100",
            "montant_total"=>"numeric",
            "tax_1_percentage"=>"numeric",
            "tax_2_percentage"=>"numeric",
            "tax_1_amount"=>"numeric",
            "tax_2_amount"=>"numeric",
            "total_order"=>"numeric",
            "ttc_total_order"=>"numeric",

            "order_comment"=>"max:200",
            "remise_order"=>"numeric",

            "date_order"=>"date",
            "due_date_order"=>"date",
            "products"=>"array",
        ];
    }


    public function messages()
    {
        return [
            'customer_id.numeric' => 'Veuillez selectionner un client',
            'date_order.date' => 'Veuillez selectionner une date de creation',
            'due_date_order.date' => 'Veuillez selectionner d\'echeance ',

            // ..
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            /*'order_key' => sha1(time()),
            'order_status' => 1,*/
        ]);
    }
}
