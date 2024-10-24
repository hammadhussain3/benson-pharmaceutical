<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'contact_person_name' => 'nullable|string',
            'contact_person_phone' => 'nullable|string',
            'contact_person_email' => 'nullable|email',
            'is_active' => 'boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
