<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
