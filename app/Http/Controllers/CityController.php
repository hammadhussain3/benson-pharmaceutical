<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Services\CityService;
use App\Services\CountryService;
use App\Models\City;

class CityController extends Controller
{
    protected $cityService;
    protected $countryService; // Declare CountryService

    public function __construct(CityService $cityService, CountryService $countryService) // Inject CountryService
    {
        $this->cityService = $cityService;
        $this->countryService = $countryService; // Initialize CountryService
    }

    public function index()
    {
        $cities = $this->cityService->getAllCities();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        // Fetch the countries to be passed to the view
        $countries = $this->countryService->getAllCountries(); // Adjust according to your service method
        return view('admin.cities.create', compact('countries')); // Pass countries to the view
    }

    public function store(CityRequest $request)
    {
        $this->cityService->createCity($request->validated());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        // Fetch the countries to be passed to the view
        $countries = $this->countryService->getAllCountries(); // Adjust according to your service method
        return view('admin.cities.edit', compact('city', 'countries')); // Pass countries to the view
    }

    public function update(CityRequest $request, City $city)
    {
        $this->cityService->updateCity($city, $request->validated());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $this->cityService->deleteCity($city);
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
    public function getCitiesByCountry($countryId)
    {

        $cities = City::where('country_id', $countryId)->get();
        return response()->json(['cities' => $cities]);
    }
}
