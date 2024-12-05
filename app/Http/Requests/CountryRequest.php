<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
