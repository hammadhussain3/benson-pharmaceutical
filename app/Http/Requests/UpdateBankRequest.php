<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBankRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'country_id' => 'required|exists:countries,id', // Adjust based on your countries table
        ];
    }
}
