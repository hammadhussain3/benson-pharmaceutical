<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectionReturnNoteRequest extends FormRequest
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
            'supplier' => 'required|exists:parties,id',
            'invoice' => 'required|exists:invoices,id',
            'supplier_bill_no' => 'required|string|max:255',
            'store_issue_requisition' => 'required|exists:store_issue_requisitions,id',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product' => 'nullable|required_if:items.*.types,product|exists:products,id',
            'items.*.raw_material_item' => 'nullable|required_if:items.*.types,raw_material_item|exists:raw_material_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.unit' => 'required|string|max:50',
            'items.*.total' => 'required|numeric|min:0',
            'items.*.remarks' => 'required',
        ];
    }
}
