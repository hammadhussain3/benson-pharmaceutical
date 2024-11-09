<?php

namespace App\Services;

use App\Models\Party;

class PartyService
{
    public function getAllParties()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $party = Party::orderBy('name', 'asc')->get();
        } else {
            $party = Party::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $party;
    }

    public function createParty(array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        return Party::create($data);
    }

    public function updateParty(Party $party, array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        $party->update($data);
        return $party;
    }

    public function deleteParty(Party $party)
    {
        $party->delete();
        return true;
    }

    public function getPartyById($id)
    {
        return Party::findOrFail($id);
    }
}
