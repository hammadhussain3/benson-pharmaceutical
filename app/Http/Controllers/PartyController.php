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
}
