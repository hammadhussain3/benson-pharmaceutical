<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'company' => 'required|exists:companies,id',
            'prefix' => 'required|string|max:50',
            'description' => 'nullable|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
