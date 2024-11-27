<?php

namespace App\Http\Controllers;

use App\Models\LeftOverNote;
use App\Http\Requests\LeftOverNoteRequest;
use App\Services\StoreIssueRequisitionService;
use App\Services\LeftOverNoteService;
use App\Services\DepartmentService;
use App\Services\ProductService;
use App\Services\CompanyService;
use App\Services\BatchService;

class LeftOverNoteController extends Controller
{
    protected $storeIssueRequisitionService;
    protected $leftOverNoteService;
    protected $departmentService;
    protected $productService;
    protected $companyService;
    protected $batchService;

    public function __construct(StoreIssueRequisitionService $storeIssueRequisitionService, LeftOverNoteService $leftOverNoteService, DepartmentService $departmentService, ProductService $productService, CompanyService $companyService, BatchService $batchService)
    {
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->leftOverNoteService = $leftOverNoteService;
        $this->departmentService = $departmentService;
        $this->productService = $productService;
        $this->companyService = $companyService;
        $this->batchService = $batchService;
    }

    public function index()
    {
        $leftOverNotes = $this->leftOverNoteService->getAll();
        return view('admin.left-over-notes.index', compact('leftOverNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newLeftOverNoteCode = "LON";
        } else {
            $newLeftOverNoteCode = $this->leftOverNoteService->createCode(auth()->user()->employee->company_id);
        }
        $requisitions = $this->storeIssueRequisitionService->getAll();
        $departments = $this->departmentService->getAllDepartments();
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $batches = $this->batchService->getAllBatches();
        return view('admin.left-over-notes.create', compact('requisitions', 'departments', 'companies', 'products', 'batches', 'newLeftOverNoteCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeftOverNoteRequest $request)
    {
        $this->leftOverNoteService->create($request->validated());
        return redirect()->route('left-over-notes.index')->with('success', 'Left Over Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $leftOverNote = $this->leftOverNoteService->getById($id);
        return view('admin.left-over-notes.show', compact('leftOverNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $leftOverNote = $this->leftOverNoteService->getById($id);
        $requisitions = $this->storeIssueRequisitionService->getAll();
        $departments = $this->departmentService->getAllDepartments();
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $batches = $this->batchService->getAllBatches();
        return view('admin.left-over-notes.edit', compact('leftOverNote', 'requisitions', 'departments', 'companies', 'products', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeftOverNoteRequest $request, LeftOverNote $leftOverNote)
    {
        $this->leftOverNoteService->update($leftOverNote, $request->validated());
        return redirect()->route('left-over-notes.index')->with('success', 'Left Over Note updated successfully');
    }

    public function destroy(LeftOverNote $leftOverNote)
    {
        $this->leftOverNoteService->delete($leftOverNote);
        return redirect()->route('left-over-notes.index')->with('success', 'Left Over Note deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $left_over_note_code = $this->leftOverNoteService->createCode($companyId);
        return response()->json(['left_over_note_code' => $left_over_note_code]);
    }
}
