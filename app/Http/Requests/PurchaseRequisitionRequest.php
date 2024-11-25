<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequisitionRequest extends FormRequest
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
        $purchaseRequisitionId = $this->purchaseRequisition ? $this->purchaseRequisition->id : null;

        return [
            'code' => 'required|string|max:255|unique:purchase_requisitions,code,' . $purchaseRequisitionId . ',id,company_id,' . $this->company_id,
            'required_date' => 'required|date|after_or_equal:today',
            'total_amount' => 'required|numeric|min:0',
            'special_instructions' => 'nullable|string',
            'company' => 'required|exists:companies,id',
            'supplier' => 'required|exists:parties,id,is_supplier,1',
            'name.*' => 'required|string|max:255',
            'quantity.*' => 'required|numeric|min:0',
            'unit.*' => 'nullable|string|max:255',
            'price.*' => 'nullable|numeric|min:0',
            'amount.*' => 'nullable|numeric|min:0',
        ];
    }
}
