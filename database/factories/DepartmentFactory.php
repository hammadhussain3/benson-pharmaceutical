<?php

namespace Database\Factories;
// database/factories/DepartmentFactory.php
use App\Models\Department;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->word(),
            'Description' => $this->faker->sentence(),
            'Company_id' => Company::factory(),

        ];
    }
}
