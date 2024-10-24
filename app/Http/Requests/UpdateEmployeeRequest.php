<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this based on your authorization logic
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:employees,code,' . $this->route('employee')->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'basic_pay' => 'required|numeric',
            'allowances' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'designation_id' => 'required|exists:designations,id',
            'department_id' => 'required|exists:departments,id',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_account' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'branch_id' => 'required|exists:branches,id',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
