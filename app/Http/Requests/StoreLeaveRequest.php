<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function rules()
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        
        return [
            'employee' => 'required|exists:employees,id',
            'leave_type' => 'required|array',
            'leave_type.*' => 'required|exists:leave_types,id',
            'days' => 'required|array',
            'days.*' => 'required|integer|min:0',
            'company' => 'required|exists:companies,id',
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
        ];
    }

    public function authorize()
    {
        return true;
    }
}