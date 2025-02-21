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

            // Validate month (1-12)
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

            // Validate year (not in the future and within last 10 years)
            'year' => [
                'required',
                'integer',
                'min:' . ($currentYear - 9),
                'max:' . $currentYear,
            ],

            'company' => 'required|exists:companies,id',
        ];
    }
}
