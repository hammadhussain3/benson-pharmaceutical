<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}