<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RawMaterialItemRequest extends FormRequest
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
        $rawMaterialItemId = $this->rawMaterialItem ? $this->rawMaterialItem->id : null;

        return [
			'name' => 'required|string|max:255',
			'code' => 'required|string|unique:employees,code,' . $rawMaterialItemId . ',id,company_id,' . $this->company_id,
			'unit' => 'required|string|max:10',
            'min_level' => 'required|string|max:10',
            'max_level' => 'required|string|max:10',
            'party' => 'required|exists:parties,id',
			'company' => 'required|exists:companies,id',
        ];
    }
}