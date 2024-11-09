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
            ->join('pack_forms', 'product_variations.pack_form_id', '=', 'pack_forms.id')
            ->join('pack_sizes', 'product_variations.pack_size_id', '=', 'pack_sizes.id')
            ->join('packing_types', 'product_variations.packing_type_id', '=', 'packing_types.id')
            ->orderBy('products.name', 'asc')
            ->select(
                'product_variations.*', 
                'products.name as product_name', 
                'companies.name as company_name',
                'dosage_forms.name as dosage_form_name',
                'pack_forms.name as pack_form_name',
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
        $data['product_id'] = $data['product'];
        $data['dosage_form_id'] = $data['dosage_form'];
        $data['pack_form_id'] = $data['pack_form'];
        $data['pack_size_id'] = $data['pack_size'];
        $data['packing_type_id'] = $data['packing_type'];
        $data['company_id'] = $data['company'];
        return ProductVariation::create($data);
    }

    public function updateProductVariation(ProductVariation $productVariation, array $data)
    {
        $data['product_id'] = $data['product'];
        $data['dosage_form_id'] = $data['dosage_form'];
        $data['pack_form_id'] = $data['pack_form'];
        $data['pack_size_id'] = $data['pack_size'];
        $data['packing_type_id'] = $data['packing_type'];
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
}