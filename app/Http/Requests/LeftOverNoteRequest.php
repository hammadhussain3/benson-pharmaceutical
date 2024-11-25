<?php

namespace App\Http\Requests;

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
        return [
			'product' => 'required|exists:products,id',
            'batch' => 'nullable|exists:batches,id',
			'department' => 'nullable|exists:departments,id',
			'store_issue_requisition' => 'required|exists:store_issue_requisitions,id',
			'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.raw_material_item' => 'nullable|exists:raw_material_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.unit' => 'required|string|max:50',
            'items.*.total' => 'required|numeric|min:0',
            'items.*.remarks' => 'nullable',
        ];
    }
}
