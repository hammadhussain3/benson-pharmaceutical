<?php

namespace App\Http\Requests;

use App\Models\EmployeeType;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this based on your authorization logic
    }

    public function rules()
    {
        $employeeId = $this->employee ? $this->employee->id : null;
        
        $employeeType = null;
        if ($this->employee_type) {
            $employeeType = EmployeeType::find($this->employee_type);
        }
        
        return [
            'code' => 'required|string|max:255|unique:employees,code,' . $employeeId . ',id,company_id,' . $this->company_id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
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
            'employee_type' => 'required|exists:employee_types,id',
            'date_of_appointment' => ($employeeType && strtolower($employeeType->type) == 'permanent') ? 'required|date' : 'nullable|date',
        ];
    }
}
