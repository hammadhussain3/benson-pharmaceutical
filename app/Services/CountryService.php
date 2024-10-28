<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Validation\ValidationException;

class CountryService
{
    public function getAllCountries()
    {
        return Country::orderBy('name', 'asc')->get();
    }

    public function createCountry(array $data)
    {
        return Country::create($data);
    }

    public function updateCountry(Country $country, array $data)
    {
        $country->update($data);
        return $country;
    }

    public function deleteCountry(Country $country)
    {
        $country->delete();
    }

    public function validateCountry(array $data)
    {
        $validator = \Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
