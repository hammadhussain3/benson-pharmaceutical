<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $employeeId = $this->employee ? $this->employee->id : null;

        return [
            'code' => 'required|string|unique:employees,code,' . $employeeId . ',id,company_id,' . $this->company_id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'net_salary' => 'required|numeric|min:0',
            'basic_pay' => 'required|numeric|min:0',
            'allowances' => 'required|numeric|min:0',
            'date_of_joining' => 'required|date',
            'designation_id' => 'required|exists:designations,id',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}
