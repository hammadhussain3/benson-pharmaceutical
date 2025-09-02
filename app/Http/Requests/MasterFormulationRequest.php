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
            'product' => 'required|exists:products,id',
            'batch_size' => 'required|numeric|min:0.01',
            'product_quantity' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'product.required' => 'Product is required.',
            'product.exists' => 'Selected product does not exist.',
            'batch_size.required' => 'Batch size is required.',
            'batch_size.numeric' => 'Batch size must be a number.',
            'batch_size.min' => 'Batch size must be greater than 0.',
            'product_quantity.required' => 'Product quantity is required.',
            'product_quantity.numeric' => 'Product quantity must be a number.',
            'product_quantity.min' => 'Product quantity must be greater than 0.',
        ];
    }
}
