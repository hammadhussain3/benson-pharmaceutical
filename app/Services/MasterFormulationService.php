<?php

namespace App\Services;

use App\Models\MasterFormulation;
use Illuminate\Support\Facades\Auth;

class MasterFormulationService
{
    public function getAllMasterFormulations()
    {
        $masterFormulations = MasterFormulation::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();
        return $masterFormulations;
    }

    public function createMasterFormulation(array $data)
    {
        return MasterFormulation::create($data);
    }

    public function updateMasterFormulation(MasterFormulation $masterFormulation, array $data)
    {
        return $masterFormulation->update($data);
    }

    public function deleteMasterFormulation(MasterFormulation $masterFormulation)
    {
        return $masterFormulation->delete();
    }

    public function getMasterFormulationById($id)
    {
        return MasterFormulation::with(['creator', 'updater'])->findOrFail($id);
    }
}
