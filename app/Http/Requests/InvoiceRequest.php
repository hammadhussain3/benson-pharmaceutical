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
		$id = $this->route('purchase_invoice') ? $this->route('purchase_invoice') : ($this->route('sale_invoice') ? $this->route('sale_invoice') : null);
		$isEdit = !is_null($id);

		return [
			'code' => 'required|string|max:255|unique:invoices,code,' . $id . ',id,company_id,' . $this->company_id,
			'type' => 'required|string|in:sale,purchase,quotation',
			'prefix' => 'required|string|size:2',
			'party' => [
				'sometimes',
				function ($attribute, $value, $fail) {
					$request = $this;

					$isSale = $request->type === 'sale';
					$isApprovedPurchase = $request->type === 'purchase' && $request->is_approved;

					if (($isSale || $isApprovedPurchase) && empty($value)) {
						$fail('The party field is required.');
					}

					if (!empty($value) && !\DB::table('parties')->where('id', $value)->exists()) {
						$fail('The selected party does not exist.');
					}
				}
			],
			'required_date' => [
				'required_if:type,purchase',
				'date',
				function ($attribute, $value, $fail) use ($isEdit) {
					if (!$isEdit && $value <= today()->format('Y-m-d')) {
						$fail('The ' . $attribute . ' must be a date after today.');
					}
				},
			],
			'order_number' => 'nullable|string|max:255',
			'order_date' => 'nullable|date|before_or_equal:today',
			'is_urgent' => 'required_if:type,purchase|in:0,1',
			'company' => 'required|exists:companies,id',
			'invoice_tax_rate' => 'nullable|numeric|min:0',
			'total_invoice_tax' => 'nullable|numeric|min:0',
			'items_cost_with_tax' => 'nullable|numeric|min:0',
			'items_cost_without_tax' => 'nullable|numeric|min:0',
			'shipped via' => 'nullable|string|max:255',
			'shipping_cost' => 'required_if:type,sale|numeric|min:0',
			'total_amount' => 'required|numeric|min:0',
			'discount_type' => 'nullable|string|in:percent,flat',
			'discount' => 'nullable|numeric|min:0',
			'paid_amount' => 'nullable|numeric|min:0',
			'returned_amount' => 'nullable|numeric|min:0',
			'due_amount' => 'nullable|numeric|min:0',
			'note' => 'nullable|string|max:1000',
			'status' => 'nullable|in:pending,completed,partial',
			'payment_deadline' => 'nullable|date|after:today',
			'invoice_items' => 'required|array|min:1',
            'invoice_items.*.raw_material_item' => 'required_if:type,purchase|string|exists:raw_material_items,id',
            'invoice_items.*.product' => 'required_if:type,sale,quotation|string|exists:product_variations,id',
			'invoice_items.*.batch' => 'required_if:type,sale|string|exists:batches,id',
            'invoice_items.*.unit' => 'required|string',
			'invoice_items.*.unit_price' => [
				'sometimes',
				function ($attribute, $value, $fail) {
					$request = $this;

					$isPurchaseApproval = $request->type === 'purchase' && $request->is_approved;

					if (
						($request->type !== 'purchase' || $isPurchaseApproval) &&
						($value === null || $value === '')
					) {
						$fail('The unit price is required.');
					}

					if ($value !== null && $value !== '' && (!is_numeric($value) || $value < 0)) {
						$fail('The unit price must be a valid non-negative number.');
					}
				},
			],
			'invoice_items.*.quantity' => 'required|integer|min:1',
			'invoice_items.*.tax_rate' => 'nullable|numeric|min:0',
			'invoice_items.*.discount_type' => 'required|string|in:percent,flat',
			'invoice_items.*.discount' => 'nullable|numeric|min:0',
			'invoice_items.*.trans_code' => 'nullable|numeric|min:0',
            'invoice_items.*.total_amount' => 'required|numeric|min:0',
			'is_approved' => 'nullable|boolean',
		];
    }

	protected function prepareForValidation()
	{
		if ($this->type === 'sale') {
			if ($this->has('invoice_items') && is_array($this->invoice_items)) {
			$filtered = array_filter($this->invoice_items, function ($item) {
				// Define what "empty" means. Here, we check if required fields are missing.
				return !empty($item['product']) && !empty($item['batch']);
			});

			$this->merge([
				'invoice_items' => array_values($filtered) // reindex the array
			]);
		}
		}
	}
}