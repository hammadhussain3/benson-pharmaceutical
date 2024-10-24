<?php

namespace Database\Factories;
// database/factories/BankFactory.php
use App\Models\Bank;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    protected $model = Bank::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->company(),
            'Acronym' => $this->faker->word(),
            'Country_id' => Country::factory(),


        ];
    }
}
