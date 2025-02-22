<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalarySlipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $currentYear = date('Y');
        $currentMonth = date('n');

        return [
            'employee' => 'required|exists:employees,id',
            'leaves' => 'required',
            'leave_id' => 'required',
            'late_in_early_out_deduction' => 'required|numeric|min:0',
            'overtime' => 'required|numeric|min:0',
            'arrears' => 'required|numeric|min:0',
            'income_tax' => 'required|numeric|min:0',
            'loan_advance' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:bank_transfer,cash',

            'month' => [
                'required',
                'integer',
                'min:1',
                'max:12',
                function ($attribute, $value, $fail) use ($currentYear, $currentMonth) {
                    if (request()->year == $currentYear && $value > $currentMonth) {
                        $fail('The selected month cannot be in the future.');
                    }
                },
            ],

            'year' => [
                'required',
                'integer',
                'min:' . ($currentYear - 9),
                'max:' . $currentYear,
            ],

            'company' => 'required|exists:companies,id',
            
            'allowance_names' => 'nullable|array',
            'allowance_names.*' => 'required_with:allowance_amounts.*|string|max:255',
            'allowance_amounts' => 'nullable|array',
            'allowance_amounts.*' => 'required_with:allowance_names.*|numeric|min:0',

            'deduction_names' => 'nullable|array',
            'deduction_names.*' => 'required_with:deduction_amounts.*|string|max:255',
            'deduction_amounts' => 'nullable|array',
            'deduction_amounts.*' => 'required_with:deduction_names.*|numeric|min:0',
        ];
    }
}
