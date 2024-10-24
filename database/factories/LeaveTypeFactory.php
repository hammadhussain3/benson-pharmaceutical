<?php

namespace Database\Factories;
// database/factories/LeaveTypeFactory.php
use App\Models\LeaveType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    protected $model = LeaveType::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->word(),
            'Company_id' => Company::factory(),

        ];
    }
}
