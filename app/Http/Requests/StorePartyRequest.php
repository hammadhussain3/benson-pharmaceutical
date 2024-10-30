<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:50',
            'contact_person_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'nullable|email|max:255',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:500',
            'payment_type' => 'required|exists:payment_types,id',
            'is_supplier' => 'required|boolean',
            'is_distributor' => 'required|boolean',
            'company' => 'nullable|exists:companies,id',
        ];
    }
}
