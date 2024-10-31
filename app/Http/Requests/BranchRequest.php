<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'phone' => 'required|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'nullable|email',
            'contact_person_name' => 'nullable|string',
            'contact_person_phone' => 'nullable|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'contact_person_email' => 'nullable|email',
            'is_active' => 'boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
