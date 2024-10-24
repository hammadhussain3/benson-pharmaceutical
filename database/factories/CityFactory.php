<?php

namespace Database\Factories;
// database/factories/CityFactory.php
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->city(),
            'Country_id' => Country::factory(),

        ];
    }
}
