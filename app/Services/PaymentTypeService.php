<?php

namespace App\Services;

use App\Models\PaymentType;

class PaymentTypeService
{
    public function getAllPaymentTypes()
    {
        $paymentTypesQuery = PaymentType::orderBy('name', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $paymentTypesQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $paymentTypes = $paymentTypesQuery->get();

        return $paymentTypes;
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
    public function getPaymentTypeById($id)
    {
        return PaymentType::findOrFail($id);
    }
}
