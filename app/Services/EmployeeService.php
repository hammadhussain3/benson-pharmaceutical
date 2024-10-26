<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{
    public function createEmployee(array $data)
    {
        return Employee::create($data);
    }

    public function updateEmployee(Employee $employee, array $data)
    {
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(Employee $employee)
    {
        return $employee->delete();
    }

    public function getAllEmployees()
    {
        $user = Auth::user();

        if ($user->hasRole('Superadmin')) {

            return Employee::select('*', DB::raw("CONCAT(first_name, ' ', last_name) as full_name"))
                ->orderBy('full_name', 'asc')
                ->get();
        } else {
            
            return Employee::select('*', DB::raw("CONCAT(first_name, ' ', last_name) as full_name"))
                ->where('company_id', $user->employee->company_id)
                ->orderBy('full_name', 'asc')
                ->get();
        }
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }
}
