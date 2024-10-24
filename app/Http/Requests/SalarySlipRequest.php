<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalarySlipRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust according to your authorization logic
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'auth_leave' => 'required|integer|min:0',
            'unauth_leave' => 'required|integer|min:0',
            'approved_with_pay' => 'required|numeric|min:0',
            'late_in_early_out_deduction' => 'required|numeric|min:0',
            'overtime' => 'required|numeric|min:0',
            'arrears' => 'required|numeric|min:0',
            'income_tax' => 'required|numeric|min:0',
            'loan_advance' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:bank_transfer,cash',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
