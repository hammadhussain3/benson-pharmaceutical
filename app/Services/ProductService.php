<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $product = Product::orderBy('name', 'asc')->get();
        } else {
            $product = Product::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $product;
    }

    public function createProduct(array $data)
    {
        // $data['product_group_id'] = $data['product_group'];
        $data['company_id'] = $data['company'];
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        // $data['product_group_id'] = $data['product_group'];
        $data['company_id'] = $data['company'];
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function createProductCode($company_id)
    {
        $lastProductCode = Product::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastProductCode) {
            $numberPart = (int) substr($lastProductCode, 3);
            $newNumberPart = $numberPart + 1;
            $newProductCode = 'PRD' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newProductCode = 'PRD00001';
        }
        return $newProductCode;
    }
}