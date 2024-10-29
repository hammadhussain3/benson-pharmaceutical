<?php
// app/Http/Requests/UpdateCompanyRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'phone' => 'nullable|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'ntn' => 'nullable|string|max:20',
            'strn' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:512',
        ];
    }
}
