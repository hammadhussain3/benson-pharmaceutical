<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('batch');

        return [
            'master_formulation_id' => 'required|exists:master_formulations,id',
            'batch_no' => [
                'required',
                'string',
                Rule::unique('batches', 'batch_no')
                    ->where('company_id', $this->company)
                    ->ignore($id),
            ],
            'batch_size' => 'required|numeric|min:1',
            'product' => 'required|exists:products,id',
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'chart_of_account' => 'required|exists:chart_of_accounts,id',
            'sub_chart_of_account' => 'required|exists:sub_chart_of_accounts,id',
            'status' => 'required|string',
            'company' => 'required|exists:companies,id',
            'items' => 'required|array|min:1',
            'items.*.product_variation' => 'required|string|exists:product_variations,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.trade_price' => 'required|numeric|min:1',
        ];
    }
}