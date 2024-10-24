<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Validation\ValidationException;

class CityService
{
    public function getAllCities()
    {
        return City::all();
    }

    public function createCity(array $data)
    {
        return City::create($data);
    }

    public function updateCity(City $city, array $data)
    {
        $city->update($data);
        return $city;
    }

    public function deleteCity(City $city)
    {
        $city->delete();
    }

    public function validateCity(array $data)
    {
        $validator = \Validator::make($data, [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
