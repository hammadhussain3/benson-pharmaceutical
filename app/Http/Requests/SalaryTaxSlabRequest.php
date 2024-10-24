<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryTaxSlabRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slab_start' => 'required|numeric',
            'slab_end' => 'required|numeric',
            'tax_value' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function authorize()
    {
        return true; // Adjust according to your authorization logic
    }
}
