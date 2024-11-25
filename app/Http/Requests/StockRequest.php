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
            'product' => [
                'required',
                'string', // Ensure the product field contains the prefix to differentiate
                function ($attribute, $value, $fail) {
                    // Extract prefix and ID from the value (e.g., 'product_5' or 'raw_3')
                    [$type, $id] = explode('_', $value, 2);

                    if ($type === 'product' && !\App\Models\Product::where('id', $id)->exists()) {
                        $fail("The selected product ($value) does not exist.");
                    } elseif ($type === 'raw' && !\App\Models\RawMaterialItem::where('id', $id)->exists()) {
                        $fail("The selected raw material ($value) does not exist.");
                    }
                }
            ],
			'quantity' => 'required|integer|min:0',
			'unit' => 'required|string',
			'unit_price' => 'required|numeric|min:0',
			'total' => 'required|numeric|min:0',
			'company' => 'required|exists:companies,id',
        ];
    }
}
