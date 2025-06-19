<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubChartOfAccountRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('sub_chart_of_account');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_chart_of_accounts', 'name')
                    ->where(fn ($query) => $query->where('chart_of_account_id', $this->chart_of_account))
                    ->ignore($id),
            ],
            'chart_of_account' => 'required|exists:chart_of_accounts,id',
            'category' => 'required|exists:categories,id',
            'company' => 'required|exists:companies,id',
        ];
    }
}
