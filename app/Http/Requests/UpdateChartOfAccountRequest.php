<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChartOfAccountRequest extends FormRequest
{
    public function rules()
    {
        $chartOfAccountId = $this->route('chart_of_account');

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:chart_of_accounts,code,' . $chartOfAccountId,
            'company' => 'required|exists:companies,id',
        ];
    }
}
