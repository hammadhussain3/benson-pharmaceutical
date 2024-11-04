<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Validation\ValidationException;

class CityService
{
    public function getAllCities()
    {
        return City::orderBy('name', 'asc')->get();
    }

    public function createCity(array $data)
    {
        $data['country_id'] = $data['country'];
        return City::create($data);
    }

    public function updateCity(City $city, array $data)
    {
        $data['country_id'] = $data['country'];
        $city->update($data);
        return $city;
    }

    public function deleteCity(City $city)
    {
        $city->delete();
    }

    public function getCityById($id)
    {
        return City::findOrFail($id);
    }

    public function validateCity(array $data)
    {
        $validator = \Validator::make($data, [
            'name' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
