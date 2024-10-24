<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    // In your RoleRequest file
    public function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name,' . $this->role->id, // Ignore the current role's ID
            'guard_name' => 'required|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
