<?php

namespace Database\Factories;
// database/factories/LoanFactory.php
use App\Models\Loan;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        return [
            'Employee_id' => Employee::factory(),
            'Amount' => $this->faker->randomFloat(2, 1000, 5000),
            'Payback_months' => $this->faker->numberBetween(1, 12),
            'remaining' => $this->faker->randomFloat(2, 0, 5000),
            'Company_id' => Company::factory(),

        ];
    }
}
