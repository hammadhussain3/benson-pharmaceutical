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
            'status' => 'nullable|in:Pending,Complete,Partial',
            'company' => 'required|exists:companies,id',
            'supplier' => 'nullable|exists:parties,id,is_supplier,1',
            'name.*' => 'required|string|max:255',
            'quantity.*' => 'required|numeric|min:0',
            'unit.*' => 'required|string|max:255',
            'price.*' => 'required|numeric|min:0',
            'amount.*' => 'required|numeric|min:0',
            'is_approved' => 'nullable|boolean',
        ];
    }
}