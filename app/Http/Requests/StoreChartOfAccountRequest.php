<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChartOfAccountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'particular' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:chart_of_accounts,code',
            'company' => 'required|exists:companies,id',
        ];
    }
}
