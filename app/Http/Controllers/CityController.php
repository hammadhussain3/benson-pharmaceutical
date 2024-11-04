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
        if (!auth()->user()->hasPermission('Cities List')) {
            abort(403, 'Unauthorized action.');
        }
        $cities = $this->cityService->getAllCities();
        return view('admin.cities.index', compact('cities'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Cities View')) {
            abort(403, 'Unauthorized action.');
        }
        $city = $this->cityService->getCityById($id);
        return view('admin.cities.view', compact('city'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Cities Create')) {
            abort(403, 'Unauthorized action.');
        }
        // Fetch the countries to be passed to the view
        $countries = $this->countryService->getAllCountries(); // Adjust according to your service method
        return view('admin.cities.create', compact('countries')); // Pass countries to the view
    }

    public function store(CityRequest $request)
    {
        if (!auth()->user()->hasPermission('Cities Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->cityService->createCity($request->validated());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        if (!auth()->user()->hasPermission('Cities Update')) {
            abort(403, 'Unauthorized action.');
        }
        // Fetch the countries to be passed to the view
        $countries = $this->countryService->getAllCountries(); // Adjust according to your service method
        return view('admin.cities.edit', compact('city', 'countries')); // Pass countries to the view
    }

    public function update(CityRequest $request, City $city)
    {
        if (!auth()->user()->hasPermission('Cities Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->cityService->updateCity($city, $request->validated());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        if (!auth()->user()->hasPermission('Cities Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->cityService->deleteCity($city);
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
    public function getCitiesByCountry($countryId)
    {
        if (!auth()->user()->hasPermission('Cities List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $cities = City::where('country_id', $countryId)->orderBy('name', 'asc')->get();
        return response()->json(['cities' => $cities]);
    }
}
