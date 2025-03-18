<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsReceivingRequest extends FormRequest
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
        $goodsReceivingId = $this->goodsReceiving ? $this->goodsReceiving->id : null;

        return [
            'code' => 'required|string|max:255|unique:goods_receivings,code,' . $goodsReceivingId . ',id,company_id,' . $this->company_id,
            'invoice' => 'required|integer|exists:invoices,id',
            'supplier' => 'required|integer|exists:parties,id',
            'supplier_bill_no' => 'required|string|max:255',
            'company' => 'required|integer|exists:companies,id',
            'sales_tax' => 'required|numeric|min:0',
            'adv_tax' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:1',
            'is_approved' => 'nullable|boolean',
            'items' => 'required|array|min:1',
            'items.*.code' => 'required|string|max:50',
            'items.*.product' => 'nullable|integer|exists:products,id|required_without:items.*.raw_material_item',
            'items.*.raw_material_item' => 'nullable|integer|exists:raw_material_items,id|required_without:items.*.product',
            'items.*.batch' => 'nullable|integer|exists:batches,id',
            'items.*.quantity_ordered' => 'required|numeric|min:1',
            'items.*.quantity_received' => 'required|numeric|min:0',
            'items.*.balance_receivable' => 'required|numeric|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:1',
            'items.*.total_amount' => 'required|numeric|min:1',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            foreach ($items as $index => $item) {
                $quantityOrdered = $item['quantity_ordered'] ?? 0;
                $quantityReceived = $item['quantity_received'] ?? 0;
                $balanceReceivable = $item['balance_receivable'] ?? 0;

                if (($quantityReceived + $balanceReceivable) > $quantityOrdered) {
                    $validator->errors()->add(
                        "items.$index.balance_receivable",
                        "Balance receivable should not be greater than quantity ordered for item $index."
                    );
                }
            }
        });
    }
}