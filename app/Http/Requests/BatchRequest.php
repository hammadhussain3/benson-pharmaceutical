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
            'batch_no' => 'required|string|unique:batches,batch_no,NULL,id,company_id,' . $this->company,
            'batch_size' => 'required|numeric|min:1',
            'product' => 'required|exists:products,id',
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status' => 'required|string',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product_variation' => 'required|string|exists:product_variations,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.trade_price' => 'required|numeric|min:1',
        ];
    }
}