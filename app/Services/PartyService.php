<?php

namespace App\Services;

use App\Models\Party;

class PartyService
{
    public function getAllParties()
    {
        return Party::all();
    }

    public function createParty(array $data)
    {
        return Party::create($data);
    }

    public function updateParty(Party $party, array $data)
    {
        $party->update($data);
        return $party;
    }

    public function deleteParty(Party $party)
    {
        $party->delete();
        return true;
    }
}
