<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust according to your authorization logic
    }

    public function rules()
    {
        return [
            'employee' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'payback_months' => 'required|integer|min:1',
            'remaining' => 'required|numeric|min:0',
            'company' => 'required|exists:companies,id',
        ];
    }
}
