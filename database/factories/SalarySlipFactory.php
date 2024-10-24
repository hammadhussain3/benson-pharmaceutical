<?php

namespace Database\Factories;

use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalarySlipFactory extends Factory
{
    protected $model = SalarySlip::class;

    public function definition()
    {
        // Fetch existing IDs for foreign keys
        $employeeIds = Employee::pluck('id')->toArray();
        $companyIds = Company::pluck('id')->toArray();

        return [
            'Employee_id' => $this->faker->randomElement($employeeIds), // Use an existing Employee ID
            'Auth_leave' => $this->faker->numberBetween(0, 10),
            'Unauth_leave' => $this->faker->numberBetween(0, 10),
            'Approved_with_pay' => $this->faker->numberBetween(0, 10),
            'Late_in_early_out_deduction' => $this->faker->randomFloat(2, 0, 100),
            'Overtime' => $this->faker->randomFloat(2, 0, 100),
            'Arrears' => $this->faker->randomFloat(2, 0, 100),
            'Income_tax' => $this->faker->randomFloat(2, 0, 100),
            'Loan_advance' => $this->faker->randomFloat(2, 0, 100),
            'Payment_mode' => $this->faker->randomElement(['bank_transfer', 'cash']),
            'Company_id' => $this->faker->randomElement($companyIds), // Use an existing Company ID
        ];
    }
}
