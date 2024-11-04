<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{
    public function createEmployee(array $data)
    {
        $data['company_id'] = $data['company'];
        $data['branch_id'] = $data['branch'];
        $data['department_id'] = $data['department'];
        $data['designation_id'] = $data['designation'];
        $data['bank_id'] = $data['bank'];
        return Employee::create($data);
    }

    public function updateEmployee(Employee $employee, array $data)
    {
        $data['company_id'] = $data['company'];
        $data['branch_id'] = $data['branch'];
        $data['department_id'] = $data['department'];
        $data['designation_id'] = $data['designation'];
        $data['bank_id'] = $data['bank'];
        User::where('employee_id', $employee->id)->update([
            'email' => $data['email']
        ]);
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(Employee $employee)
    {
        return $employee->delete();
    }

    public function getAllEmployees()
    {
        $employeesQuery = Employee::select('*', DB::raw("CONCAT(first_name, ' ', last_name) as full_name"))
            ->orderBy('full_name', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $employeesQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $employees = $employeesQuery->get();

        return $employees;
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function createEmployeeCode($company_id)
    {
        $lastEmployeeCode = Employee::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastEmployeeCode) {
            $numberPart = (int) substr($lastEmployeeCode, 3);
            $newNumberPart = $numberPart + 1;
            $newEmployeeCode = 'EMP' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newEmployeeCode = 'EMP00001';
        }
        return $newEmployeeCode;
    }
}
