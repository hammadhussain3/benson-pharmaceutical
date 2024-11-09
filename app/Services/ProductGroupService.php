<?php

namespace App\Services;

use App\Models\ProductGroup;

class ProductGroupService
{
    public function getAllProductGroups()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $productGroup = ProductGroup::orderBy('name', 'asc')->get();
        } else {
            $productGroup = ProductGroup::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $productGroup;
    }

    public function createProductGroup(array $data)
    {
        $data['company_id'] = $data['company'];
        return ProductGroup::create($data);
    }

    public function updateProductGroup(ProductGroup $productGroup, array $data)
    {
        $data['company_id'] = $data['company'];
        $productGroup->update($data);
        return $productGroup;
    }

    public function deleteProductGroup(ProductGroup $productGroup)
    {
        return $productGroup->delete();
    }

    public function getProductGroupById($id)
    {
        return ProductGroup::findOrFail($id);
    }
}