<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee' => 'required|exists:employees,id',
            'leave_type' => 'required|exists:leave_types,id',
            'days' => 'required|integer|min:1',
            'company' => 'required|exists:companies,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
