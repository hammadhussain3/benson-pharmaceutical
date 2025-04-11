<?php

namespace App\Services;

use App\Models\SalaryAllowances;
use App\Models\SalarySlip;
use App\Models\Loan;

class SalarySlipService
{
    public function createSalarySlip(array $data)
    {
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];

        $loan = Loan::where('employee_id', $data['employee_id'])
                    ->orderBy('created_at', 'desc')
                    ->first();

        if ($loan) {
            $loanAmount = $loan->remaining - $data['loan_advance'];
            
            if ($loanAmount < 0) {
                throw new \Exception('Loan remaining cannot be negative after deduction.');
            }
            $loan->update(['remaining' => $loanAmount]);
        }

        $data['leaves'] = array_map(function ($id, $days) {
            return [
                'id' => $id,
                'days' => $days,
            ];
        }, $data['leave_id'], $data['leaves']);

        $salary = SalarySlip::create($data);

        if (!empty($data['allowance_names']) && !empty($data['allowance_amounts'])) {
            foreach ($data['allowance_names'] as $index => $name) {
                SalaryAllowances::create([
                    'employee_id' => $data['employee_id'],
                    'salary_slip_id' => $salary->id,
                    'name' => $name,
                    'amount' => $data['allowance_amounts'][$index],
                    'type' => 'allowance'
                ]);
            }
        }

        if (!empty($data['deduction_names']) && !empty($data['deduction_amounts'])) {
            foreach ($data['deduction_names'] as $index => $name) {
                SalaryAllowances::create([
                    'employee_id' => $data['employee_id'],
                    'salary_slip_id' => $salary->id,
                    'name' => $name,
                    'amount' => $data['deduction_amounts'][$index],
                    'type' => 'deduction',
                ]);
            }
        }

        return $salary;
    }

    public function updateSalarySlip(SalarySlip $salarySlip, array $data)
    {
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];

        $data['leaves'] = array_map(function ($id, $days) {
            return [
                'id' => $id,
                'days' => $days,
            ];
        }, $data['leave_id'], $data['leaves']);

        $salarySlip->update($data);
        
        $salarySlip->allowances()->delete();

        if (!empty($data['allowance_names']) && !empty($data['allowance_amounts'])) {
            foreach ($data['allowance_names'] as $index => $name) {
                SalaryAllowances::create([
                    'employee_id' => $data['employee_id'],
                    'salary_slip_id' => $salarySlip->id,
                    'name' => $name,
                    'amount' => $data['allowance_amounts'][$index],
                    'type' => 'allowance'
                ]);
            }
        }

        if (!empty($data['deduction_names']) && !empty($data['deduction_amounts'])) {
            foreach ($data['deduction_names'] as $index => $name) {
                SalaryAllowances::create([
                    'employee_id' => $data['employee_id'],
                    'salary_slip_id' => $salarySlip->id,
                    'name' => $name,
                    'amount' => $data['deduction_amounts'][$index],
                    'type' => 'deduction',
                ]);
            }
        }

        return $salarySlip;
    }
}