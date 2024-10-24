<?php

namespace Database\Factories;
// database/factories/DesignationFactory.php
use App\Models\Designation;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesignationFactory extends Factory
{
    protected $model = Designation::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->word(),
            'Company_id' => Company::factory(),

        ];
    }
}
