<?php

namespace Database\Factories;
// database/factories/SalaryTaxSlabFactory.php
use App\Models\SalaryTaxSlab;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryTaxSlabFactory extends Factory
{
    protected $model = SalaryTaxSlab::class;

    public function definition()
    {
        return [
            'Slab_start' => $this->faker->numberBetween(10000, 50000),
            'Slab_end' => $this->faker->numberBetween(50001, 100000),
            'Tax_value' => $this->faker->numberBetween(5, 30),
            'Company_id' => Company::factory(),

        ];
    }
}
