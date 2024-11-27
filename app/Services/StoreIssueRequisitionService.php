<?php

namespace App\Services;

use App\Models\StoreIssueRequisition;
use App\Models\StoreIssueRequisitionItem;

class StoreIssueRequisitionService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $requisitions = StoreIssueRequisition::with(['chart_of_account', 'product', 'batch', 'company'])->orderBy('created_at', 'asc')->get();
        } else {
            $requisitions = StoreIssueRequisition::with(['chart_of_account', 'product', 'batch', 'company'])->where('company', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $requisitions;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['chart_of_account_id'] = $data['chart_of_account'] ?? null;
        $data['product_id'] = $data['product'] ?? null;
        $data['batch_id'] = $data['batch'] ?? null;
        $data['company_id'] = $data['company'];

        $requisition = StoreIssueRequisition::create($data);

        foreach ($items as $item) {
            if(isset($item['product'])){
                if (str_starts_with($item['product'], 'product_')) {
                    $item['product_id'] = str_replace('product_', '', $item['product']);
                    $item['raw_material_item_id'] = null;
                    $item['product_variation_id'] = null;
                } elseif (str_starts_with($item['product'], 'raw_')) {
                    $item['raw_material_item_id'] = str_replace('raw_', '', $item['product']);
                    $item['product_id'] = null;
                    $item['product_variation_id'] = null;
                } elseif (str_starts_with($item['product'], 'var_')) {
                    $item['product_variation_id'] = str_replace('var_', '', $item['product']);
                    $item['raw_material_item_id'] = null;
                    $item['product_id'] = null;
                }
            } elseif(isset($item['raw_material_item'])){
                $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
            }

            $requisition->items()->create($item);
            $item['company_id'] = $data['company_id'];
            $requisition->stocks()->create($item);
        }

        return $requisition;
    }

    public function update(StoreIssueRequisition $storeIssueRequisition, array $data)
    {
        $items = $data['items'] ?? [];

        $data['chart_of_account_id'] = $data['chart_of_account'] ?? null;
        $data['product_id'] = $data['product'] ?? null;
        $data['batch_id'] = $data['batch'] ?? null;
        $data['company_id'] = $data['company'];

        $storeIssueRequisition->update($data);

        $storeIssueRequisition->items()->delete();
        $item['company_id'] = $data['company_id'];
        $storeIssueRequisition->stocks()->delete();

        foreach ($items as $item) {
            if(isset($item['product'])){
                if (str_starts_with($item['product'], 'product_')) {
                    $item['product_id'] = str_replace('product_', '', $item['product']);
                    $item['raw_material_item_id'] = null;
                    $item['product_variation_id'] = null;
                } elseif (str_starts_with($item['product'], 'raw_')) {
                    $item['raw_material_item_id'] = str_replace('raw_', '', $item['product']);
                    $item['product_id'] = null;
                    $item['product_variation_id'] = null;
                } elseif (str_starts_with($item['product'], 'var_')) {
                    $item['product_variation_id'] = str_replace('var_', '', $item['product']);
                    $item['raw_material_item_id'] = null;
                    $item['product_id'] = null;
                }
            } elseif(isset($item['raw_material_item'])){
                $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
            }

            $storeIssueRequisition->items()->create($item);
            $item['company_id'] = $data['company_id'];
            $storeIssueRequisition->stocks()->create($item);
        }

        return $storeIssueRequisition;        
    }

    public function delete(StoreIssueRequisition $storeIssueRequisition)
    {
        $storeIssueRequisition->stocks()->delete();
        return $storeIssueRequisition->delete();
    }

    public function getById($id)
    {
        return StoreIssueRequisition::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastRequisitionCode = StoreIssueRequisition::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastRequisitionCode) {
            $numberPart = (int) substr($lastRequisitionCode, 3);
            $newNumberPart = $numberPart + 1;
            $newRequisitionCode = 'SIR' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newRequisitionCode = 'SIR00001';
        }
        return $newRequisitionCode;
    }
}