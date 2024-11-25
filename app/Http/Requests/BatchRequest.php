<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'batch_no' => 'required|string',
			'batch_size' => 'required|string',
			'product' => 'required|exists:products,id',
			'mfg_date' => 'required|string',
			'exp_date' => 'required|string',
			'status' => 'required|string',
            'company' => 'required|exists:companies,id',
        ];
    }
}
