<?php

namespace Database\Factories;
// database/factories/CountryFactory.php
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->country(),


        ];
    }
}
