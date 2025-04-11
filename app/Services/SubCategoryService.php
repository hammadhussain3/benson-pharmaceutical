<?php

namespace App\Services;

use App\Models\SubCategory;

class SubCategoryService
{
    public function getAll()
    {
        $query = SubCategory::with('category')->orderBy('name', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $query->whereHas('category', function ($q) {
                $q->where('company_id', auth()->user()->employee->company_id);
            });
        }

        return $query->get();
    }

    public function create(array $data)
    {
        $data['category_id'] = $data['category'];
        return SubCategory::create($data);
    }

    public function update(SubCategory $subCategory, array $data)
    {
        $data['category_id'] = $data['category'];
        $subCategory->update($data);
        return $subCategory;
    }

    public function delete(SubCategory $subCategory)
    {
        $subCategory->delete();
        return true;
    }

    public function getById($id)
    {
        return SubCategory::findOrFail($id);
    }
}