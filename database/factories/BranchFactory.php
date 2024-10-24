<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Country; // Import Country model
use App\Models\City;    // Import City model
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition()
    {
        // Fetch existing country and city IDs
        $countryIds = Country::pluck('id')->toArray();
        $cityIds = City::pluck('id')->toArray();

        return [
            'Company_id' => Company::factory(), // Creates a new Company entry
            'Name' => $this->faker->word(),
            'Address' => $this->faker->address(),
            'Country_id' => $this->faker->randomElement($countryIds), // Use an existing country ID
            'City_id' => $this->faker->randomElement($cityIds), // Use an existing city ID
            'Phone' => $this->faker->phoneNumber(),
            'Email' => $this->faker->safeEmail(),
            'Contact_person_name' => $this->faker->name(),
            'Contact_person_phone' => $this->faker->phoneNumber(),
            'Contact_person_email' => $this->faker->safeEmail(),
            'Is_active' => $this->faker->boolean(),
        ];
    }
}
