<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeTypeResquest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $employeeTypeId = $this->employee_type ? $this->employee_type->id : null;

        return [
            'type' => 'required|string|max:255|unique:employee_types,type,' . $employeeTypeId,
            'description' => 'nullable|string',
            'company' => 'required|exists:companies,id',
        ];
    }
}
