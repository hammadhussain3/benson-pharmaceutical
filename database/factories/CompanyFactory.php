<?php

namespace Database\Factories;
// database/factories/CompanyFactory.php
use App\Models\Company;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->company(),
            'Address' => $this->faker->address(),
            'Country_id' => Country::factory(),
            'City_id' => City::factory(),
            'Phone' => $this->faker->phoneNumber(),
            'Email' => $this->faker->safeEmail(),
            'Website' => $this->faker->url(),
            'NTN' => $this->faker->numerify('###-#####-#'),
            'STRN' => $this->faker->numerify('###-#####-#'),
            'Is_active' => $this->faker->boolean(),
            'Logo_path' => $this->faker->imageUrl(),

        ];
    }
}
