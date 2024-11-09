<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $category = Category::orderBy('name', 'asc')->get();
        } else {
            $category = Category::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $category;
    }

    public function createCategory(array $data)
    {
        $data['company_id'] = $data['company'];
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        $data['company_id'] = $data['company'];
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return true;
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }
}
