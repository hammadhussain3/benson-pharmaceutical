<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
		$invoiceId = $this->invoice ? $this->invoice->id : null;

		return [
			'code' => 'required|string|max:255|unique:invoices,code,' . $invoiceId . ',id,company_id,' . $this->company_id,
			'type' => 'required|string|in:sale,purchase,quotation',
			'prefix' => 'required|string|size:2',
			'party' => 'required|exists:parties,id',
			'required_date' => 'required|date|after:today',
			'is_urgent' => 'required|in:0,1',
			'company' => 'required|exists:companies,id',
			'invoice_tax_rate' => 'required|numeric|min:0',
			'total_invoice_tax' => 'required|numeric|min:0',
			'items_cost_with_tax' => 'required|numeric|min:0',
			'items_cost_without_tax' => 'required|numeric|min:0',
			'shipping_cost' => 'required|numeric|min:0',
			'total_amount' => 'required|numeric|min:0',
			'discount_type' => 'required',
			'discount' => 'required|numeric|min:0',
			'note' => 'nullable|string|max:1000',
			'payment_deadline' => 'required|date|after:today',
			'invoice_items' => 'required|array|min:1',
			'invoice_items.*.product' => [
                'required',
                'string', // Ensure the product field contains the prefix to differentiate
                function ($attribute, $value, $fail) {
                    // Extract prefix and ID from the value (e.g., 'product_5' or 'raw_3')
                    [$type, $id] = explode('_', $value, 2);

                    if ($type === 'product' && !\App\Models\Product::where('id', $id)->exists()) {
                        $fail("The selected product ($value) does not exist.");
                    } elseif ($type === 'raw' && !\App\Models\RawMaterialItem::where('id', $id)->exists()) {
                        $fail("The selected raw material ($value) does not exist.");
                    }
                }
            ],
            'invoice_items.*.unit' => 'required|string',
			'invoice_items.*.unit_price' => 'required|numeric|min:0',
			'invoice_items.*.product_quantity' => 'required|integer|min:1',
			'invoice_items.*.tax_rate' => 'nullable|numeric|min:0',
			'invoice_items.*.discount_type' => 'required|string|in:percent,flat',
			'invoice_items.*.discount' => 'nullable|numeric|min:0',
            'invoice_items.*.total_amount' => 'required|numeric|min:0',
		];
    }
}