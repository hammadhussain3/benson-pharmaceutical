<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_no' => 'required|string',
            'batch_size' => 'required|numeric|min:1',
            'product' => 'required|exists:products,id',
            'mfg_date' => 'required|string',
            'exp_date' => 'required|string',
            'status' => 'required|string',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product_variation' => 'required|string|exists:product_variations,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.trade_price' => 'required|numeric|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $batchSize = (int) $this->input('batch_size', 0);

            $totalQuantity = collect($items)->sum('quantity');

            if ($batchSize !== $totalQuantity) {
                $validator->errors()->add('batch_size', 'The batch size must be equal to the total quantity of all items.');
            }
        });
    }
}