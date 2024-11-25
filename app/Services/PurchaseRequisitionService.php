<?php

namespace App\Services;

use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionItem;

class PurchaseRequisitionService
{
    public function getAllPurchaseRequisitions()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $purchaseRequisitions = PurchaseRequisition::orderBy('required_date', 'asc')->get();
        } else {
            $purchaseRequisitions = PurchaseRequisition::where('company_id', auth()->user()->employee->company_id)->orderBy('required_date', 'asc')->get();
        }
        return $purchaseRequisitions;
    }

    public function createPurchaseRequisition(array $data)
    {
        $purchaseRequisitionData['code'] = $data['code'];
        $purchaseRequisitionData['required_date'] = $data['required_date'];
        $purchaseRequisitionData['supplier_id'] = $data['supplier'];
        $purchaseRequisitionData['total_amount'] = $data['total_amount'];
        $purchaseRequisitionData['special_instructions'] = $data['special_instructions'];
        $purchaseRequisitionData['company_id'] = $data['company'];
        $purchaseRequisition = PurchaseRequisition::create($purchaseRequisitionData);
        foreach ($data['name'] as $key => $name) {
            $purchaseRequisitionItemData['purchase_requisition_id'] = $purchaseRequisition->id;
            $purchaseRequisitionItemData['name'] = $name;
            $purchaseRequisitionItemData['quantity'] = $data['quantity'][$key];
            $purchaseRequisitionItemData['unit'] = $data['unit'][$key];
            $purchaseRequisitionItemData['price'] = $data['price'][$key];
            $purchaseRequisitionItemData['amount'] = $data['amount'][$key];
            $purchaseRequisitionItemData['company_id'] = $data['company'];
            PurchaseRequisitionItem::create($purchaseRequisitionItemData);
        }
        return $data;
    }

    public function updatePurchaseRequisition(PurchaseRequisition $purchaseRequisition, array $data)
    {
        $purchaseRequisitionData['required_date'] = $data['required_date'];
        $purchaseRequisitionData['supplier_id'] = $data['supplier'];
        $purchaseRequisitionData['total_amount'] = $data['total_amount'];
        $purchaseRequisitionData['special_instructions'] = $data['special_instructions'];
        $purchaseRequisitionData['company_id'] = $data['company'];
        $purchaseRequisition->update($purchaseRequisitionData);
        $purchaseRequisition->purchaseRequisitionItems()->delete();
        foreach ($data['name'] as $key => $name) {
            $purchaseRequisitionItemData['purchase_requisition_id'] = $purchaseRequisition->id;
            $purchaseRequisitionItemData['name'] = $name;
            $purchaseRequisitionItemData['quantity'] = $data['quantity'][$key];
            $purchaseRequisitionItemData['unit'] = $data['unit'][$key];
            $purchaseRequisitionItemData['price'] = $data['price'][$key];
            $purchaseRequisitionItemData['amount'] = $data['amount'][$key];
            $purchaseRequisitionItemData['company_id'] = $data['company'];
            PurchaseRequisitionItem::create($purchaseRequisitionItemData);
        }
        return $data;
    }

    public function deletePurchaseRequisition(PurchaseRequisition $purchaseRequisition)
    {
        return $purchaseRequisition->delete();
    }

    public function getPurchaseRequisitionById($id)
    {
        return PurchaseRequisition::findOrFail($id);
    }

    public function createPurchaseRequisitionCode($company_id)
    {
        $lastPurchaseRequisitionCode = PurchaseRequisition::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastPurchaseRequisitionCode) {
            $numberPart = (int) substr($lastPurchaseRequisitionCode, 3);
            $newNumberPart = $numberPart + 1;
            $newPurchaseRequisitionCode = 'MPR' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newPurchaseRequisitionCode = 'MPR00001';
        }
        return $newPurchaseRequisitionCode;
    }
}