<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
			'raw_material_item' => 'required|exists:raw_material_items,id',
			'available_quantity' => 'required|integer|min:0',
			'unit' => 'required|string',
			'rate' => 'required|numeric|min:0',
			'value' => 'required|numeric|min:0',
			'min_level' => 'required|integer|min:0',
			'max_level' => 'required|integer|min:0',
			'company' => 'required|exists:companies,id',
        ];
    }
}
