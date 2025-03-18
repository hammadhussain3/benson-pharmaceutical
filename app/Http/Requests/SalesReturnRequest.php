<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesReturnRequest extends FormRequest
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
        $id = $this->route('sales-returns') ? $this->route('sales-returns')->id : null;

		return [
            'code' => 'required|string|max:255|unique:sales_returns,code,' . $id . ',id,company_id,' . $this->company_id,
            'party' => 'required|exists:parties,id',
            'inclusive_tax' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
			'total_tax' => 'required|numeric|min:0',
			'exclusive_tax' => 'required|numeric|min:0',
            'discount_type' => 'required|string|in:percent,flat',
			'discount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:1',
            'is_approved' => 'nullable|boolean',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product' => 'required|string|exists:product_variations,id',
            'items.*.batch' => 'nullable|string|exists:batches,id',
            'items.*.unit' => 'required|string',
			'items.*.unit_price' => 'required|numeric|min:0',
			'items.*.quantity' => 'required|integer|min:1',
			'items.*.tax_rate' => 'nullable|numeric|min:0',
			'items.*.discount_type' => 'required|string|in:percent,flat',
			'items.*.discount' => 'nullable|numeric|min:0',
			'items.*.trans_code' => 'nullable|numeric|min:0',
            'items.*.total_amount' => 'required|numeric|min:1',
        ];
    }
}
