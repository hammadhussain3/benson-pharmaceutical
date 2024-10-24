<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust according to your authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'ntn' => 'nullable|string|max:20',
            'strn' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo_path' => 'nullable|string|max:255',
        ];
    }
}
