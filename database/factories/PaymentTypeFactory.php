<?php

namespace Database\Factories;
// database/factories/PaymentTypeFactory.php
use App\Models\PaymentType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTypeFactory extends Factory
{
    protected $model = PaymentType::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->word(),
            'Description' => $this->faker->sentence(),
            'Company_id' => Company::factory(),

        ];
    }
}
