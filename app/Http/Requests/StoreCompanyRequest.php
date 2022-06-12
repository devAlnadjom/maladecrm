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
            'name' => "string|required|max:200",
            'address'=>"string|required|max:255",
            'categorie'=>"string|required|max:255",
            'contact'=>"string|required|max:20",
            'description' =>"max:5000",
            'owner_id' =>"numeric"
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'owner_id' => auth()->user()->id,
        ]);
    }
}
