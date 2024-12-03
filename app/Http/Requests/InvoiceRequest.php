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
			'required_date' => 'required_if:type,purchase|date|after:today',
			'order_number' => 'required_if:type,sale|string|max:255',
			'order_date' => 'required_if:type,sale|date|before:today',
			'is_urgent' => 'required_if:type,purchase|in:0,1',
			'company' => 'required|exists:companies,id',
			'invoice_tax_rate' => 'required|numeric|min:0',
			'total_invoice_tax' => 'required|numeric|min:0',
			'items_cost_with_tax' => 'required|numeric|min:0',
			'items_cost_without_tax' => 'required|numeric|min:0',
			'shipped via' => 'nullable|string|max:255',
			'shipping_cost' => 'required_if:type,sale|numeric|min:0',
			'total_amount' => 'required|numeric|min:1',
			'discount_type' => 'required|string|in:percent,flat',
			'discount' => 'required|numeric|min:0',
			'note' => 'nullable|string|max:1000',
			'payment_deadline' => 'required_if:type,sale|date|after:today',
			'invoice_items' => 'required|array|min:1',
            'invoice_items.*.raw_material_item' => 'required_if:type,purchase|string|exists:raw_material_items,id',
            'invoice_items.*.product' => 'required_if:type,sale,quotation|string|exists:product_variations,id',
			'invoice_items.*.batch' => 'required_if:type,sale|string|exists:batches,id',
            'invoice_items.*.unit' => 'required|string',
			'invoice_items.*.unit_price' => 'required|numeric|min:0',
			'invoice_items.*.quantity' => 'required|integer|min:1',
			'invoice_items.*.tax_rate' => 'nullable|numeric|min:0',
			'invoice_items.*.discount_type' => 'required|string|in:percent,flat',
			'invoice_items.*.discount' => 'nullable|numeric|min:0',
			'invoice_items.*.trans_code' => 'nullable|numeric|min:0',
            'invoice_items.*.total_amount' => 'required|numeric|min:1',
		];
    }
}