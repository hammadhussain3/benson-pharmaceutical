<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RawMaterialItem;

class PurchaseInvoiceService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $invoices = Invoice::where('type', 'purchase')->latest()->get();
        } else {
            $invoices = Invoice::where('type', 'purchase')->where('company_id', auth()->user()->employee->company_id)->latest()->get();
        }
        return $invoices;
    }

    public function create(array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice = Invoice::create($data);

        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $key => $value) {
                $value['raw_material_item_id'] = $value['raw_material_item'];
                $invoice->items()->create($value);
            }
        }
        return $invoice;
    }

    public function update(Invoice $invoice, array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice->update($data);
        $invoice->items()->delete();
        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $value) {
                $value['raw_material_item_id'] = $value['raw_material_item'];
                $invoice->items()->create($value);
            }
        }
        return $invoice;
    }

    public function delete(Invoice $invoice)
    {
        return $invoice->delete();
    }

    public function getById($id)
    {
        return Invoice::findOrFail($id);
    }

    public function generateCode($company_id)
    {
        $prefix = 'PO';
        $lastInvoiceCode = Invoice::latest('id')->where('prefix', 'PR')->where('company_id', $company_id)->value('code');
        if ($lastInvoiceCode) {
            $numberPart = (int) substr($lastInvoiceCode, 2);
            $newNumberPart = $numberPart + 1;
            $newInvoiceCode = $prefix . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newInvoiceCode = $prefix . '00001';
        }
        return $newInvoiceCode;
    }
}