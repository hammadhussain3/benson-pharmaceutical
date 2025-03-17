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
            'income' => 'required|numeric|min:0',
            'leave_id' => 'required',
            'late_in_early_out_deduction' => 'required|numeric|min:0',
            'eob' => 'required|numeric|min:0',
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
            
            'is_approved' => 'nullable|boolean',
        ];
    }

    /**
     * Remove empty allowances and deductions before validation.
     */
    protected function prepareForValidation()
    {
        $filteredAllowances = [];
        $filteredAllowanceAmounts = [];

        if ($this->has('allowance_names') && $this->has('allowance_amounts')) {
            foreach ($this->allowance_names as $key => $name) {
                if (!empty($name) && !empty($this->allowance_amounts[$key])) {
                    $filteredAllowances[] = $name;
                    $filteredAllowanceAmounts[] = $this->allowance_amounts[$key];
                }
            }
        }

        $filteredDeductions = [];
        $filteredDeductionAmounts = [];

        if ($this->has('deduction_names') && $this->has('deduction_amounts')) {
            foreach ($this->deduction_names as $key => $name) {
                if (!empty($name) && !empty($this->deduction_amounts[$key])) {
                    $filteredDeductions[] = $name;
                    $filteredDeductionAmounts[] = $this->deduction_amounts[$key];
                }
            }
        }

        $this->merge([
            'allowance_names' => $filteredAllowances,
            'allowance_amounts' => $filteredAllowanceAmounts,
            'deduction_names' => $filteredDeductions,
            'deduction_amounts' => $filteredDeductionAmounts,
        ]);
    }
}