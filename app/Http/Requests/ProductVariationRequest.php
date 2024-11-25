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
        return [
			'product' => 'required|exists:products,id',
			'dosage_form' => 'required|exists:dosage_forms,id',
			'pack_form' => 'required|exists:pack_forms,id',
			'packing_type' => 'required|exists:packing_types,id',
			'pack_size' => 'required|exists:pack_sizes,id',
			'trade_price' => 'required|numeric|min:0',
            'our_mrp' => 'required|numeric|min:0',
            'drap_mrp' => 'required|numeric|min:0',
			'company' => 'required|exists:companies,id',
        ];
    }
}
