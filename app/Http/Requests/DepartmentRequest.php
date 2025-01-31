<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->department ? $this->department->id : null;

        return [
            'name' => 'required|string|max:255|unique:departments,name,' . $id . ',id,branch_id,' . $this->input('branch'),
            'description' => 'nullable|string',
            'company' => 'required|exists:companies,id',
            'branch' => 'required|exists:branches,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}