<?php

namespace App\Http\Requests;

use App\Models\StoreIssueRequisitionItem;
use Illuminate\Foundation\Http\FormRequest;

class LeftOverNoteRequest extends FormRequest
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
        $leftOverNoteId = $this->leftOverNote ? $this->leftOverNote->id : null;

        return [
            'code' => 'required|string|max:255|unique:goods_receivings,code,' . $leftOverNoteId . ',id,company_id,' . $this->company_id,
			'product' => 'required|exists:products,id',
            'batch' => 'nullable|exists:batches,id',
			'department' => 'nullable|exists:departments,id',
			'store_issue_requisition' => 'required|exists:store_issue_requisitions,id',
            'is_approved' => 'nullable|boolean',
			'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.raw_material_item' => 'nullable|exists:raw_material_items,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.unit' => 'required|string|max:50',
            'items.*.total' => 'required|numeric|min:0',
            'items.*.remarks' => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);

            foreach ($items as $index => $item) {
                $storeIssueRequisition = $this->input('store_issue_requisition', null);
                $rawMaterialItemId = $item['raw_material_item'] ?? null;
                $requestedQuantity = $item['quantity'] ?? 0;

                // Calculate the balance for the specific item
                $availableBalance = StoreIssueRequisitionItem::where('raw_material_item_id', $rawMaterialItemId)->where('store_issue_requisition_id', $storeIssueRequisition)->sum('quantity');

                if ($requestedQuantity > $availableBalance) {
                    $validator->errors()->add(
                        "items.$index.quantity",
                        "The requested quantity ($requestedQuantity) exceeds given store issue requisition quantity ($availableBalance) for item $index."
                    );
                }
            }
        });
    }
}