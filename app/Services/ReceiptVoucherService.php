<?php

namespace App\Services;

use App\Models\ReceiptVoucher;
use App\Models\ReceiptVoucherItem;

class ReceiptVoucherService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $receiptVouchers = ReceiptVoucher::orderBy('created_at', 'asc')->get();
        } else {
            $receiptVouchers = ReceiptVoucher::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $receiptVouchers;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $receiptVoucher = ReceiptVoucher::create($data);

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $receiptVoucher->items()->create($value);
        }

        return $receiptVoucher;
    }

    public function update(ReceiptVoucher $receiptVoucher, array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $receiptVoucher->update($data);
        $receiptVoucher->items()->delete();

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $receiptVoucher->items()->create($value);
        }
        
        return $receiptVoucher;        
    }

    public function delete(ReceiptVoucher $receiptVoucher)
    {
        return $receiptVoucher->delete();
    }

    public function getById($id)
    {
        return ReceiptVoucher::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastReceiptVoucherCode = ReceiptVoucher::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastReceiptVoucherCode) {
            $numberPart = (int) substr($lastReceiptVoucherCode, 2);
            $newNumberPart = $numberPart + 1;
            $newReceiptVoucherCode = 'RV' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newReceiptVoucherCode = 'RV00001';
        }
        return $newReceiptVoucherCode;
    }
}