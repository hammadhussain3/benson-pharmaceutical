<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Services\CompanyService;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $companyService;
    protected $categoryService;

    public function __construct(CategoryService $categoryService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        if (!auth()->user()->hasPermission('Category List')) {
            abort(403, 'Unauthorized action.');
        }
        
        $categories = $this->categoryService->getAllCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Category Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.categories.create', compact('companies'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Category View')) {
            abort(403, 'Unauthorized action.');
        }
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.categories.view', compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        if (!auth()->user()->hasPermission('Category Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        if (!auth()->user()->hasPermission('Category Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.categories.edit', compact('category','companies'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        if (!auth()->user()->hasPermission('Category Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->categoryService->updateCategory($category, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if (!auth()->user()->hasPermission('Category Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->categoryService->deleteCategory($category);
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function getCategoriesByCompany($companyId)
    {
        $categories = Category::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['categories' => $categories]);
    }
    
    public function getCategoryPrefix($categoryId)
    {
        $category = $this->categoryService->getCategoryById($categoryId);
        return response()->json(['prefix' => $category->prefix]);
    }
}
