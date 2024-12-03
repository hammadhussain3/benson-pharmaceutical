<?php

namespace App\Services;

use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherItem;

class PaymentVoucherService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $paymentVouchers = PaymentVoucher::orderBy('created_at', 'asc')->get();
        } else {
            $paymentVouchers = PaymentVoucher::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $paymentVouchers;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $paymentVoucher = PaymentVoucher::create($data);

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $paymentVoucher->items()->create($value);
        }

        return $paymentVoucher;
    }

    public function update(PaymentVoucher $paymentVoucher, array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $paymentVoucher->update($data);
        $paymentVoucher->items()->delete();

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $paymentVoucher->items()->create($value);
        }
        
        return $paymentVoucher;        
    }

    public function delete(PaymentVoucher $paymentVoucher)
    {
        return $paymentVoucher->delete();
    }

    public function getById($id)
    {
        return PaymentVoucher::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastPaymentVoucherCode = PaymentVoucher::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastPaymentVoucherCode) {
            $numberPart = (int) substr($lastPaymentVoucherCode, 3);
            $newNumberPart = $numberPart + 1;
            $newPaymentVoucherCode = 'PVR' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newPaymentVoucherCode = 'PVR00001';
        }
        return $newPaymentVoucherCode;
    }
}