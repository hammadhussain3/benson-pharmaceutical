<?php

namespace Database\Factories;

use App\Models\Party;
use App\Models\Country;
use App\Models\City;
use App\Models\PaymentType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartyFactory extends Factory
{
    protected $model = Party::class;

    public function definition()
    {
        $countryIds = Country::pluck('id')->toArray();
        $cityIds = City::pluck('id')->toArray();
        $paymentTypeIds = PaymentType::pluck('id')->toArray();
        $companyIds = Company::pluck('id')->toArray();

        return [
            'name' => $this->faker->company(),
            'code' => $this->faker->unique()->word(),
            'contact_person_name' => $this->faker->name(),
            'contact_person_phone' => $this->faker->phoneNumber(),
            'contact_person_email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'Country_id' => $this->faker->randomElement($countryIds),
            'City_id' => $this->faker->randomElement($cityIds),
            'address' => $this->faker->address(),
            'payment_type_id' => $this->faker->randomElement($paymentTypeIds),
            'is_supplier' => $this->faker->boolean(),
            'is_distributor' => $this->faker->boolean(),
            'company_id' => $this->faker->randomElement($companyIds),
        ];
    }
}
