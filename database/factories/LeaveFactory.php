<?php

namespace Database\Factories;
// database/factories/LeaveFactory.php
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    public function definition()
    {
        return [
            'Employee_id' => Employee::factory(),
            'Leave_type_id' => LeaveType::factory(),
            'Days' => $this->faker->numberBetween(1, 30),
            'Company_id' => Company::factory(),

        ];
    }
}
