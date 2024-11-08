<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::orderBy('name', 'asc')->get();
    }

    public function createProduct(array $data)
    {
        $data['product_group_id'] = $data['product_group'];
        $data['company_id'] = $data['company'];
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        $data['product_group_id'] = $data['product_group'];
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
}
