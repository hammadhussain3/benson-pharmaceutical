<?php

namespace App\Services;

use App\Models\CreditNote;
use App\Models\CreditNoteItem;

class CreditNoteService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $creditNotes = CreditNote::orderBy('created_at', 'asc')->get();
        } else {
            $creditNotes = CreditNote::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $creditNotes;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $creditNote = CreditNote::create($data);

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $creditNote->items()->create($value);
        }

        return $creditNote;
    }

    public function update(CreditNote $creditNote, array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $creditNote->update($data);
        $creditNote->items()->delete();

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $creditNote->items()->create($value);
        }
        
        return $creditNote;        
    }

    public function delete(CreditNote $creditNote)
    {
        return $creditNote->delete();
    }

    public function getById($id)
    {
        return CreditNote::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastCreditNoteCode = CreditNote::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastCreditNoteCode) {
            $numberPart = (int) substr($lastCreditNoteCode, 2);
            $newNumberPart = $numberPart + 1;
            $newCreditNoteCode = 'CN' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newCreditNoteCode = 'CN00001';
        }
        return $newCreditNoteCode;
    }
}