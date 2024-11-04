<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:employees,code,' . $this->route('employee')->id . ',id,company_id,' . $this->company_id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $this->route('employee')->id,
            'phone' => 'required|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'basic_pay' => 'required|numeric',
            'allowances' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'designation' => 'required|exists:designations,id',
            'department' => 'required|exists:departments,id',
            'bank' => 'nullable|exists:banks,id',
            'bank_account' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'branch' => 'required|exists:branches,id',
            'company' => 'required|exists:companies,id',
        ];
    }
}
