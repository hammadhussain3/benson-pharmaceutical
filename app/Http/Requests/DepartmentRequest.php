<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company' => 'required|exists:companies,id',
            'branch' => 'required|exists:branches,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}