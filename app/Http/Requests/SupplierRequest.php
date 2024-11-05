<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'company_name' => 'required|string',
            'phone' => 'required|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'required|email',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string',
            'payment_type' => 'required|exists:payment_types,id',
        ];
    }
}
