<?php

namespace App\Http\Requests;

use App\Models\Stock;
use Illuminate\Foundation\Http\FormRequest;

class StoreIssueRequisitionRequest extends FormRequest
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
        $requisitionId = $this->route('store_issue_requisition') ? $this->route('store_issue_requisition')->id : null;

		return [
            'code' => 'required|string|max:255|unique:employees,code,' . $requisitionId . ',id,company_id,' . $this->company_id,
            'chart_of_account' => 'nullable|exists:chart_of_accounts,id|required_without:product',
            'product' => 'nullable|exists:products,id|required_without:chart_of_account',
            'batch' => 'nullable|exists:batches,id',
            'dn_gp' => 'required|string',
            'company' => 'required|exists:companies,id',
            'is_general' => 'required|boolean',
            'is_production' => 'required|boolean',
            'items' => 'required|array|min:1',
            'items.*.product' => [
                'required_with:chart_of_account',
                'nullable',
                'string', // Ensure the product field contains the prefix to differentiate
                function ($attribute, $value, $fail) {
                    // Extract prefix and ID from the value (e.g., 'product_5' or 'raw_3')
                    [$type, $id] = explode('_', $value, 2);

                    if ($type === 'product' && !\App\Models\Product::where('id', $id)->exists()) {
                        $fail("The selected product ($value) does not exist.");
                    } elseif ($type === 'raw' && !\App\Models\RawMaterialItem::where('id', $id)->exists()) {
                        $fail("The selected raw material ($value) does not exist.");
                    } elseif ($type === 'var' && !\App\Models\ProductVariation::where('id', $id)->exists()) {
                        $fail("The selected finished products ($value) does not exist.");
                    }
                }
            ],
            'items.*.raw_material_item' => 'nullable|exists:raw_material_items,id|required_with:product',
            'items.*.batch' => 'nullable|exists:batches,id',
            'items.*.unit' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.total' => 'required|numeric|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $requisitionId = $this->route('store_issue_requisition') ? $this->route('store_issue_requisition')->id : null;

            foreach ($items as $index => $item) {
                
                $productVariationId = null;
                $productId = null;
                $rawMaterialItemId = null;
                if (isset($item['product'])) {
                    [$type, $id] = explode('_', $item['product'], 2);
                    if ($type === 'product') {
                        $productId = $id;
                    } elseif ($type === 'raw') {
                        $rawMaterialItemId = $id;
                    } elseif ($type === 'var') {
                        $productVariationId = $id;
                    }
                } elseif (isset($item['raw_material_item'])) {
                    $rawMaterialItemId = $item['raw_material_item'];
                }
                
                $requestedQuantity = $item['quantity'] ?? 0;

                // Calculate the balance for the specific item
                $availableBalance = Stock::currentBalanceForItem($productId, $rawMaterialItemId, $productVariationId);
                $existBalance = Stock::where('product_id', $productId)
                    ->where('raw_material_item_id', $rawMaterialItemId)
                    ->where('product_variation_id', $productVariationId)
                    ->where('store_issue_requisition_id', $requisitionId)
                    ->value('quantity');

                $balance = $availableBalance['balance'] + $existBalance;
                
                if ($requestedQuantity > $balance) {
                    $validator->errors()->add(
                        "items.$index.quantity",
                        "The requested quantity ($requestedQuantity) exceeds available stock ($balance) for item $index."
                    );
                }
            }
        });
    }
}