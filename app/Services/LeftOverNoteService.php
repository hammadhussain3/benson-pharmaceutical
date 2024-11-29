<?php

namespace App\Services;

use App\Models\LeftOverNote;

class LeftOverNoteService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $leftOverNotes = LeftOverNote::orderBy('created_at', 'asc')->get();
        } else {
            $leftOverNotes = LeftOverNote::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $leftOverNotes;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['product_id'] = $data['product'];
        $data['batch_id'] = $data['batch'];
        $data['department_id'] = $data['department'];
        $data['store_issue_requisition_id'] = $data['store_issue_requisition'];
        $data['company_id'] = $data['company'];

        $leftOverNote = LeftOverNote::create($data);

        foreach ($items as $item) {
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;

            $leftOverNote->items()->create($item);
            $item['batch_id'] = $data['batch_id'];
            $item['company_id'] = $data['company_id'];
            $leftOverNote->stocks()->create($item);
        }

        return $leftOverNote;
    }

    public function update(LeftOverNote $leftOverNote, array $data)
    {
        $items = $data['items'] ?? [];

        $data['product_id'] = $data['product'];
        $data['batch_id'] = $data['batch'];
        $data['department_id'] = $data['department'];
        $data['store_issue_requisition_id'] = $data['store_issue_requisition'];
        $data['company_id'] = $data['company'];

        $leftOverNote->update($data);

        $leftOverNote->items()->delete();
        $leftOverNote->stocks()->delete();

        foreach ($items as $item) {
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;

            $leftOverNote->items()->create($item);
            $item['batch_id'] = $data['batch_id'];
            $item['company_id'] = $data['company_id'];
            $leftOverNote->stocks()->create($item);
        }

        return $leftOverNote;
    }

    public function delete(LeftOverNote $leftOverNote)
    {
        $leftOverNote->stocks()->delete();
        return $leftOverNote->delete();
    }

    public function getById($id)
    {
        return LeftOverNote::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastLeftOverNoteCode = LeftOverNote::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastLeftOverNoteCode) {
            $numberPart = (int) substr($lastLeftOverNoteCode, 3);
            $newNumberPart = $numberPart + 1;
            $newLeftOverNoteCode = 'LON' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newLeftOverNoteCode = 'LON00001';
        }
        return $newLeftOverNoteCode;
    }
}