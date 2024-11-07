<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::orderBy('name', 'asc')->get();
    }

    public function createCategory(array $data)
    {
        $data['name'] = $data['name'];
        $data['prefix'] = $data['prefix'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        $data['name'] = $data['name'];
        $data['prefix'] = $data['prefix'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
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
