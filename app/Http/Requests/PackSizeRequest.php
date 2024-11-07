<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackSizeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'company' => 'required|exists:companies,id',
            'description' => 'nullable|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
