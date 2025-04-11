<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $productId = $this->product ? $this->product->id : null;

        return [
			// 'reg_no' => 'required|string|unique:employees,code,' . $productId . ',id,company_id,' . $this->company_id,
			// 'name' => 'required|string|max:255',
			'generic_name' => 'required|string|max:255',
			'brand_name' => 'required|string|max:255',
			'therapeutic_class' => 'required|string|max:255',
			// 'code' => 'required|string|unique:employees,code,' . $productId . ',id,company_id,' . $this->company_id,
			// 'product_group' => 'required|exists:product_groups,id',
			'company' => 'required|exists:companies,id',
        ];
    }
}
