<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishedGoodsReceivingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'batch' => 'required|integer|exists:batches,id',
            'product' => 'required|integer|exists:products,id',
            'company' => 'required|integer|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product_variation' => 'required|integer|exists:product_variations,id',
            'items.*.quantity_received' => 'required|numeric|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ];
    }
}
