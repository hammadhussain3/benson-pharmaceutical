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

    public function getPartiesByCompany(Request $request, $companyId)
    {
        $partiesQuery = Party::where('company_id', $companyId)->orderBy('name', 'asc');
        if ($request->input('document_type') == 'purchase') {
            $parties = $partiesQuery->where('is_supplier', '1')->get();
        } elseif ($request->input('document_type') == 'sale' || $request->input('document_type') == 'quotation') {
            $parties = $partiesQuery->where('is_distributor', '1')->get();
        } else {
            $parties = $partiesQuery->get();
        }
        
        return response()->json(['parties' => $parties]);
    }

    public function getSupplierCodeByPartyId($partyId)
    {
        $party = Party::where('id', $partyId)->first();
        return response()->json(['supplier_code' => $party->code]);
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Parties List')) {
            abort(403, 'Unauthorized action.');
        }
        $parties = $this->partyService->getAllParties();
        return view('admin.parties.index', compact('parties'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Parties View')) {
            abort(403, 'Unauthorized action.');
        }
        $party = $this->partyService->getPartyById($id);
        return view('admin.parties.view', compact('party'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Parties Create')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.parties.create', compact('countries', 'cities', 'companies', 'paymentTypes'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Parties Update')) {
            abort(403, 'Unauthorized action.');
        }
        $party = Party::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.parties.edit', compact('party', 'countries', 'cities', 'companies', 'paymentTypes'));
    }
    public function store(StorePartyRequest $request)
    {
        if (!auth()->user()->hasPermission('Parties Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->partyService->createParty($request->validated());
        return redirect()->route('parties.index')->with('success', 'Party created successfully.');
    }


    public function update(UpdatePartyRequest $request, $id) // Accepting the ID
    {
        if (!auth()->user()->hasPermission('Parties Update')) {
            abort(403, 'Unauthorized action.');
        }
        $party = Party::findOrFail($id); // Explicitly using findOrFail
        $this->partyService->updateParty($party, $request->validated());
        return redirect()->route('parties.index')->with('success', 'Party updated successfully.');
    }

    public function destroy($id) // Accepting the ID
    {
        if (!auth()->user()->hasPermission('Parties Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $party = Party::findOrFail($id); // Explicitly using findOrFail
        $this->partyService->deleteParty($party);
        return redirect()->route('parties.index')->with('success', 'Party deleted successfully.');
    }
}
