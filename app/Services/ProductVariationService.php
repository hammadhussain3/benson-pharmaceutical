<?php

namespace App\Services;

use App\Models\ProductVariation;

class ProductVariationService
{
    public function getAllProductVariations()
    {
        $productVariationsQuery = ProductVariation::with('product', 'company', 'dosageForm', 'packForm', 'packSize', 'packingType')
            ->join('products', 'product_variations.product_id', '=', 'products.id')
            ->join('companies', 'product_variations.company_id', '=', 'companies.id')
            ->join('dosage_forms', 'product_variations.dosage_form_id', '=', 'dosage_forms.id')
            // ->join('pack_forms', 'product_variations.pack_form_id', '=', 'pack_forms.id')
            ->join('pack_sizes', 'product_variations.pack_size_id', '=', 'pack_sizes.id')
            ->join('packing_types', 'product_variations.packing_type_id', '=', 'packing_types.id')
            ->orderBy('products.brand_name', 'asc')
            ->select(
                'product_variations.*', 
                'products.brand_name as product_name', 
                'companies.name as company_name',
                'dosage_forms.name as dosage_form_name',
                // 'pack_forms.name as pack_form_name',
                'pack_sizes.name as pack_size_name',
                'packing_types.name as packing_type_name'
            );

        if (!auth()->user()->hasRole('Superadmin')) {
            $productVariationsQuery->where('product_variations.company_id', auth()->user()->employee->company_id);
        }

        $productVariations = $productVariationsQuery->get();

        return $productVariations;
    }

    public function createProductVariation(array $data)
    {
        $data['code'] = $data['category_prefix'] . $data['sub_category_prefix'] . $data['code'];
        $data['product_id'] = $data['product'];
        $data['dosage_form_id'] = $data['dosage_form'];
        $data['pack_form_id'] = $data['pack_form'] ?? null;
        $data['pack_size_id'] = $data['pack_size'];
        $data['packing_type_id'] = $data['packing_type'];
        $data['product_group_id'] = $data['product_group'] ?? null;
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['sub_chart_of_account_id'] = $data['sub_chart_of_account'];
        $data['company_id'] = $data['company'];
        return ProductVariation::create($data);
    }

    public function updateProductVariation(ProductVariation $productVariation, array $data)
    {
        $data['code'] = $data['category_prefix'] . $data['sub_category_prefix'] . $data['code'];
        $data['product_id'] = $data['product'];
        $data['dosage_form_id'] = $data['dosage_form'];
        $data['pack_form_id'] = $data['pack_form'] ?? null;
        $data['pack_size_id'] = $data['pack_size'];
        $data['packing_type_id'] = $data['packing_type'];
        $data['product_group_id'] = $data['product_group'] ?? null;
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['sub_chart_of_account_id'] = $data['sub_chart_of_account'];
        $data['company_id'] = $data['company'];
        $productVariation->update($data);
        return $productVariation;
    }

    public function deleteProductVariation(ProductVariation $productVariation)
    {
        return $productVariation->delete();
    }

    public function getProductVariationById($id)
    {
        return ProductVariation::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastCode = ProductVariation::latest('id')
            ->where('company_id', $company_id)
            ->value('code');

        if ($lastCode) {
            $parts = explode('-', $lastCode);
            $lastPart = array_pop($parts); // get last numeric part
            $numberPart = (int) $lastPart;
            $code = str_pad($numberPart + 1, strlen($lastPart), '0', STR_PAD_LEFT);
        } else {
            $code = '00001';
        }

        return $code;
    }
}