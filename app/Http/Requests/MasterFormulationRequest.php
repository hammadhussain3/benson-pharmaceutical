<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MasterFormulationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // brand_name is selected from dropdown of distinct names, but validated as string
            'brand_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'batch_size' => 'required|numeric|min:0.01',
            'raw_material_item_id' => 'required|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'brand_name.required' => 'Brand is required.',
            'brand_name.string' => 'Brand must be a string.',
            'brand_name.max' => 'Brand may not be greater than 255 characters.',
            'product_name.required' => 'Product name is required.',
            'product_name.string' => 'Product name must be a string.',
            'product_name.max' => 'Product name may not be greater than 255 characters.',
            'batch_size.required' => 'Batch size is required.',
            'batch_size.numeric' => 'Batch size must be a number.',
            'batch_size.min' => 'Batch size must be greater than 0.',
            'raw_material_items.required' => 'Raw material items are required.',
        ];
    }
}
