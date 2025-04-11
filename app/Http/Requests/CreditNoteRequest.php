<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditNoteRequest extends FormRequest
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
        $id = $this->route('credit-notes') ? $this->route('credit-notes')->id : null;

		return [
            'code' => 'required|string|max:255|unique:credit_notes,code,' . $id . ',id,company_id,' . $this->company_id,
            'party' => 'required|exists:parties,id',
            'description' => 'required|string',
            'total' => 'required|numeric',
            'is_approved' => 'nullable|boolean',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.chart_of_account' => 'required|exists:chart_of_accounts,id',
            'items.*.debit' => 'required|numeric|min:0',
            'items.*.credit' => 'required|numeric|min:0',
        ];
    }
}