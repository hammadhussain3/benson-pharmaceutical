<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalVoucherRequest extends FormRequest
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
        $id = $this->route('journal-vouchers') ? $this->route('journal-vouchers')->id : null;

		return [
            'code' => 'required|string|max:255|unique:journal_vouchers,code,' . $id . ',id,company_id,' . $this->company_id,
            'year' => 'required|string|max:10',
            'total_debit' => 'required|numeric|min:0',
            'total_credit' => 'required|numeric|min:0',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.chart_of_account' => 'required|exists:chart_of_accounts,id',
            'items.*.description' => 'required|string',
            'items.*.debit' => 'required|numeric|min:0',
            'items.*.credit' => 'required|numeric|min:0',
        ];
    }
}
