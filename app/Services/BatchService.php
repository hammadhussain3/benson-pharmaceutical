<?php

namespace App\Services;

use App\Models\Batch;

class BatchService
{
    public function getAllBatches()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $batches = Batch::orderBy('batch_no', 'asc')->get();
        } else {
            $batches = Batch::where('company_id', auth()->user()->employee->company_id)->orderBy('batch_no', 'asc')->get();
        }
        return $batches;
    }

    public function createBatch(array $data)
    {
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];
        return Batch::create($data);
    }

    public function updateBatch(Batch $batch, array $data)
    {
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];
        $batch->update($data);
        return $batch;
    }

    public function deleteBatch(Batch $batch)
    {
        return $batch->delete();
    }

    public function getBatchById($id)
    {
        return Batch::findOrFail($id);
    }
}