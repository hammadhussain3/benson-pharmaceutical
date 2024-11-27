<?php

namespace App\Services;

use App\Models\RejectionReturnNote;

class RejectionReturnNoteService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $rejectionReturnNotes = RejectionReturnNote::orderBy('created_at', 'asc')->get();
        } else {
            $rejectionReturnNotes = RejectionReturnNote::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $rejectionReturnNotes;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['supplier'];
        $data['invoice_id'] = $data['invoice'];
        $data['store_issue_requisition_id'] = $data['store_issue_requisition'];
        $data['company_id'] = $data['company'];
        $rejectionReturnNote = RejectionReturnNote::create($data);

        foreach ($items as $item) {
            $item['product_id'] = $item['product'] ?? null;
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;

            $rejectionReturnNote->items()->create($item);
        }

        return $rejectionReturnNote;
    }

    public function update(RejectionReturnNote $rejectionReturnNote, array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['supplier'];
        $data['invoice_id'] = $data['invoice'];
        $data['store_issue_requisition_id'] = $data['store_issue_requisition'];
        $data['company_id'] = $data['company'];

        $rejectionReturnNote->update($data);

        $rejectionReturnNote->items()->delete();

        foreach ($items as $item) {
            $item['product_id'] = $item['product'] ?? null;
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;

            $rejectionReturnNote->items()->create($item);
        }

        return $rejectionReturnNote;
    }

    public function delete(RejectionReturnNote $rejectionReturnNote)
    {
        return $rejectionReturnNote->delete();
    }

    public function getById($id)
    {
        return RejectionReturnNote::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastRejectionReturnNoteCode = RejectionReturnNote::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastRejectionReturnNoteCode) {
            $numberPart = (int) substr($lastRejectionReturnNoteCode, 3);
            $newNumberPart = $numberPart + 1;
            $newRejectionReturnNoteCode = 'RRN' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newRejectionReturnNoteCode = 'RRN00001';
        }
        return $newRejectionReturnNoteCode;
    }
}