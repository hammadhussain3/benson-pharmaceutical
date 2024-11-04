<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\Party;
use App\Models\PaymentType;
use App\Services\PartyService;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    protected $partyService;

    public function __construct(PartyService $partyService)
    {
        $this->partyService = $partyService;
    }

    public function index()
    {
        $parties = $this->partyService->getAllParties();
        return view('admin.parties.index', compact('parties'));
    }

    public function view($id)
    {
        $party = $this->partyService->getPartyById($id);
        return view('admin.parties.view', compact('party'));
    }

    public function create()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.parties.create', compact('countries', 'cities', 'companies', 'paymentTypes'));
    }

    public function edit($id)
    {
        $party = Party::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.parties.edit', compact('party', 'countries', 'cities', 'companies', 'paymentTypes'));
    }
    public function store(StorePartyRequest $request)
    {
        $this->partyService->createParty($request->validated());
        return redirect()->route('parties.index')->with('success', 'Party created successfully.');
    }




    public function update(UpdatePartyRequest $request, $id) // Accepting the ID
    {
        $party = Party::findOrFail($id); // Explicitly using findOrFail
        $this->partyService->updateParty($party, $request->validated());
        return redirect()->route('parties.index')->with('success', 'Party updated successfully.');
    }

    public function destroy($id) // Accepting the ID
    {
        $party = Party::findOrFail($id); // Explicitly using findOrFail
        $this->partyService->deleteParty($party);
        return redirect()->route('parties.index')->with('success', 'Party deleted successfully.');
    }
}
