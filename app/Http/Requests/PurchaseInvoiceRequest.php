<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseInvoiceRequest extends FormRequest
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
		$id = $this->route('purchase_invoice') ? $this->route('purchase_invoice') : null;
		$isEdit = !is_null($id);

		return [
            'type' => 'required|string|in:purchase',
            'prefix' => 'required|string|size:2',
            'company' => 'required|exists:companies,id',
            'party' => 'nullable|required_if:is_approved,1|exists:parties,id',
			'code' => 'required|string|max:255|unique:invoices,code,' . $id . ',id,company_id,' . $this->company,			
			'required_date' => 'required|date|after_or_equal:today',
            'payment_deadline' => 'nullable|date|after:today',
			'is_urgent' => 'required|in:0,1',
            'invoice_items' => 'required|array|min:1',
            'invoice_items.*.code' => 'nullable|string|max:255',
            'invoice_items.*.raw_material_item' => 'required|string|exists:raw_material_items,id',
            'invoice_items.*.balance' => 'nullable',
            'invoice_items.*.min_level' => 'nullable',
            'invoice_items.*.max_level' => 'nullable',
            'invoice_items.*.title' => 'nullable|string',
            'invoice_items.*.description' => 'nullable|string',
            'invoice_items.*.quantity' => 'required|integer|min:1',
            'invoice_items.*.unit_price' => 'required_if:is_approved,1|nullable|numeric|min:1',
            'invoice_items.*.unit' => 'required|string',
            'invoice_items.*.lp_ref' => 'nullable|string|max:255',
            'invoice_items.*.lp_price' => 'nullable',
            'invoice_items.*.ip_po_list' => 'nullable|string|max:255',
            'invoice_items.*.ip_quantity' => 'nullable',
            'invoice_items.*.consumption_6_month' => 'nullable',
            // 'invoice_items.*.tax_rate' => 'nullable|numeric|min:0',
			// 'invoice_items.*.discount_type' => 'required|string|in:percent,flat',
			// 'invoice_items.*.discount' => 'nullable|numeric|min:0',
            'invoice_items.*.total_amount' => 'required|numeric|min:0',
            // 'items_cost_without_tax' => 'nullable|numeric|min:0',
			// 'invoice_tax_rate' => 'nullable|numeric|min:0',
			// 'total_invoice_tax' => 'nullable|numeric|min:0',
			// 'items_cost_with_tax' => 'nullable|numeric|min:0',
            // 'discount_type' => 'nullable|string|in:percent,flat',
			// 'discount' => 'nullable|numeric|min:0',			
			'total_amount' => 'required|numeric|min:0',			
			'note' => 'nullable|string|max:1000',
			// 'status' => 'nullable|in:pending,completed,partial',
			'is_approved' => 'nullable|boolean',
		];
    }
}