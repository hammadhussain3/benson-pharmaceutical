<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->sub_category ? $this->sub_category->id : null;
        return [
            'category' => 'required|exists:categories,id',
            'prefix' => 'required|string|max:100|unique:sub_categories,prefix,' . $id . ',id,category_id,' . $this->category,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
