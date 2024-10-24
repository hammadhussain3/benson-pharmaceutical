<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->route('role') . ',id,guard_name,' . $this->input('guard_name'),
            'guard_name' => 'required|string|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
