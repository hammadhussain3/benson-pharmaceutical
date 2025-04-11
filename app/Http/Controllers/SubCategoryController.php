<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubCategoryRequest;
use App\Services\SubCategoryService;
use App\Services\CategoryService;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    protected $subCategoryService;
    protected $categoryService;

    public function __construct(SubCategoryService $subCategoryService, CategoryService $categoryService)
    {
        $this->subCategoryService = $subCategoryService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (!auth()->user()->hasPermission('Sub Category List')) {
            abort(403, 'Unauthorized action.');
        }
        
        $subCategories = $this->subCategoryService->getAll();
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Sub Category Create')) {
            abort(403, 'Unauthorized action.');
        }
        $categories = $this->categoryService->getAllCategories();
        return view('admin.sub-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        if (!auth()->user()->hasPermission('Sub Category Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->subCategoryService->create($request->validated());
        return redirect()->route('sub-categories.index')->with('success', 'Sub Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->hasPermission('Sub Category View')) {
            abort(403, 'Unauthorized action.');
        }
        $subCategory = $this->subCategoryService->getById($id);
        return view('admin.sub-categories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        if (!auth()->user()->hasPermission('Sub Category Update')) {
            abort(403, 'Unauthorized action.');
        }
        $categories = $this->categoryService->getAllCategories();
        return view('admin.sub-categories.edit', compact('subCategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        if (!auth()->user()->hasPermission('Sub Category Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->subCategoryService->update($subCategory, $request->validated());
        return redirect()->route('sub-categories.index')->with('success', 'Sub Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if (!auth()->user()->hasPermission('Sub Category Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->subCategoryService->delete($subCategory);
        return redirect()->route('sub-categories.index')->with('success', 'Sub Category deleted successfully!');
    }

    public function getSubCategoriesByCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)->orderBy('name', 'asc')->get();
        return response()->json(['subCategories' => $subCategories]);
    }

    public function getSubCategoryPrefix($subCategoryId)
    {
        $subCategory = $this->subCategoryService->getById($subCategoryId);
        return response()->json(['prefix' => $subCategory->prefix]);
    }
}
