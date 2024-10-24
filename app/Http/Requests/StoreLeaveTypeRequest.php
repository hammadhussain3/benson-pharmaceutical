<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
