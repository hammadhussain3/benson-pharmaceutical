<?php

namespace App\Services;

use App\Models\PaymentType;

class PaymentTypeService
{
    public function getAllPaymentTypes()
    {
        return PaymentType::all();
    }
    public function createPaymentType($data)
    {
        return PaymentType::create($data);
    }

    public function updatePaymentType(PaymentType $paymentType, $data)
    {
        return $paymentType->update($data);
    }

    public function deletePaymentType(PaymentType $paymentType)
    {
        return $paymentType->delete();
    }
}
