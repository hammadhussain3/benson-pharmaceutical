<?php

namespace App\Services;

use App\Models\PaymentType;

class PaymentTypeService
{
    public function getAllPaymentTypes()
    {
        return PaymentType::orderBy('name', 'asc')->get();
    }
    public function createPaymentType($data)
    {
        $data['company_id'] = $data['company'];
        return PaymentType::create($data);
    }

    public function updatePaymentType(PaymentType $paymentType, $data)
    {
        $data['company_id'] = $data['company'];
        return $paymentType->update($data);
    }

    public function deletePaymentType(PaymentType $paymentType)
    {
        return $paymentType->delete();
    }
}
