<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationRequest extends FormRequest
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
        $id = $this->product ? $this->product : null;

        return [
            'code' => 'required|string|unique:employees,code,' . $id . ',id,company_id,' . $this->company,
            'reg_no' => 'required|string|unique:employees,code,' . $id . ',id,company_id,' . $this->company,
            'category_prefix' => 'required',
            'sub_category_prefix' => 'nullable',
			'product' => 'required|exists:products,id',
            'strength' => 'nullable|string|max:50',
			'dosage_form' => 'required|exists:dosage_forms,id',
			'pack_form' => 'nullable|exists:pack_forms,id',
			'packing_type' => 'required|exists:packing_types,id',
			'pack_size' => 'required|exists:pack_sizes,id',
			'trade_price' => 'required|numeric|min:0',
            'product_group' => 'nullable|exists:product_groups,id',
			'category' => 'required|exists:categories,id',
            'sub_category' => 'nullable|exists:sub_categories,id',
            'chart_of_account' => 'required|exists:chart_of_accounts,id',
            'sub_chart_of_account' => 'nullable|exists:sub_chart_of_accounts,id',
            'our_mrp' => 'required|numeric|min:0',
            'drap_mrp' => 'required|numeric|min:0',
            'min_level' => 'required|numeric|min:0',
            'max_level' => 'required|numeric|min:0',
			'company' => 'required|exists:companies,id',
        ];
    }
}