<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->city ? $this->city->id : null;

        return [
            'name' => 'required|string|max:255|unique:cities,name,' . $id . ',id,country_id,' . $this->input('country'),
            'country' => 'required|exists:countries,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
