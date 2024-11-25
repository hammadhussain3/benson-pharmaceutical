<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceService
{
    public function getAllInvoices()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $invoices = Invoice::orderBy('required_date', 'asc')->get();
        } else {
            $invoices = Invoice::where('company_id', auth()->user()->employee->company_id)->orderBy('required_date', 'asc')->get();
        }
        return $invoices;
    }

    public function createInvoice(array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice = Invoice::create($data);

        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $key => $value) {
                $value['invoice_id'] = $invoice->id;
                if (str_starts_with($value['product'], 'product_')) {
                    $value['product_id'] = str_replace('product_', '', $value['product']);
                    $value['raw_material_item_id'] = null;
                } elseif (str_starts_with($value['product'], 'raw_')) {
                    $value['raw_material_item_id'] = str_replace('raw_', '', $value['product']);
                    $value['product_id'] = null;
                }
                InvoiceItem::create($value);
            }
        }
        return $data;
    }

    public function updateInvoice(Invoice $invoice, array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice->update($data);
        $invoice->items()->delete();
        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $value) {
                $value['invoice_id'] = $invoice->id;
                if (str_starts_with($value['product'], 'product_')) {
                    $value['product_id'] = str_replace('product_', '', $value['product']);
                    $value['raw_material_item_id'] = null;
                } elseif (str_starts_with($value['product'], 'raw_')) {
                    $value['raw_material_item_id'] = str_replace('raw_', '', $value['product']);
                    $value['product_id'] = null;
                }
                InvoiceItem::create($value);
            }
        }
        return $data;
    }

    public function deleteInvoice(Invoice $invoice)
    {
        return $invoice->delete();
    }

    public function getInvoiceById($id)
    {
        return Invoice::findOrFail($id);
    }

    public function createInvoiceCode($company_id, $type)
    {
        $prefix = $type == 'sale' ? 'SI' : ($type == 'purchase' ? 'PR' : ($type == 'quotation' ? 'QT' : ''));
        $lastInvoiceCode = Invoice::latest('id')->where('prefix', $prefix)->where('company_id', $company_id)->value('code');
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