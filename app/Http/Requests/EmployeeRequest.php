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
            'code' => 'required|string|unique:employees,code,' . $employeeId,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'net_salary' => 'required|numeric',
            'basic_pay' => 'required|numeric',
            'allowances' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'designation_id' => 'required|exists:designations,id',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
