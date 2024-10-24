<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
