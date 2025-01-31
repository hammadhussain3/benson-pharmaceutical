<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->country ? $this->country->id : null;

        return [
            'name' => 'required|string|max:255|unique:countries,name,' .$id. ',id',
            'currency' => 'required|string|max:3',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
