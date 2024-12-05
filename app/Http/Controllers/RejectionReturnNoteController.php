<?php

namespace App\Http\Controllers;

use App\Models\RejectionReturnNote;
use App\Http\Requests\RejectionReturnNoteRequest;
use App\Services\StoreIssueRequisitionService;
use App\Services\RejectionReturnNoteService;
use App\Services\GoodsReceivingService;
use App\Services\CompanyService;
use App\Services\InvoiceService;


class RejectionReturnNoteController extends Controller
{
    protected $storeIssueRequisitionService;
    protected $rejectionReturnNoteService;
    protected $goodsReceivingService;
    protected $invoiceService;
    protected $companyService;

    public function __construct(RejectionReturnNoteService $rejectionReturnNoteService, InvoiceService $invoiceService, CompanyService $companyService, GoodsReceivingService $goodsReceivingService, StoreIssueRequisitionService $storeIssueRequisitionService)
    {
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->rejectionReturnNoteService = $rejectionReturnNoteService;
        $this->goodsReceivingService = $goodsReceivingService;
        $this->invoiceService = $invoiceService;
        $this->companyService = $companyService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Rejection Return Note List')) {
            abort(403, 'Unauthorized action.');
        }
        $rejectionReturnNotes = $this->rejectionReturnNoteService->getAll();
        return view('admin.rejection-return-notes.index', compact('rejectionReturnNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Rejection Return Note Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newRejectionCode = "RRN";
        } else {
            $newRejectionCode = $this->rejectionReturnNoteService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $invoices = $this->invoiceService->getAllInvoices('purchase');
        $goodsReceivings = $this->goodsReceivingService->getAllGoodsReceivings();
        $requisitions = $this->storeIssueRequisitionService->getAll();
        return view('admin.rejection-return-notes.create', compact('companies', 'invoices', 'goodsReceivings', 'requisitions', 'newRejectionCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RejectionReturnNoteRequest $request)
    {
        if (!auth()->user()->hasPermission('Rejection Return Note Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rejectionReturnNoteService->create($request->validated());
        return redirect()->route('rejection-return-notes.index')->with('success', 'Rejection Return Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Rejection Return Note View')) {
            abort(403, 'Unauthorized action.');
        }
        $rejectionReturnNote = $this->rejectionReturnNoteService->getById($id);
        return view('admin.rejection-return-notes.show', compact('rejectionReturnNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Rejection Return Note Update')) {
            abort(403, 'Unauthorized action.');
        }
        $rejectionReturnNote = $this->rejectionReturnNoteService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $invoices = $this->invoiceService->getAllInvoices('purchase');
        $goodsReceivings = $this->goodsReceivingService->getAllGoodsReceivings();
        $requisitions = $this->storeIssueRequisitionService->getAll();
        return view('admin.rejection-return-notes.edit', compact('rejectionReturnNote', 'companies', 'invoices', 'goodsReceivings', 'requisitions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RejectionReturnNoteRequest $request, RejectionReturnNote $rejectionReturnNote)
    {
        if (!auth()->user()->hasPermission('Rejection Return Note Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rejectionReturnNoteService->update($rejectionReturnNote, $request->validated());
        return redirect()->route('rejection-return-notes.index')->with('success', 'Rejection Return Note updated successfully');
    }

    public function destroy(RejectionReturnNote $rejectionReturnNote)
    {
        if (!auth()->user()->hasPermission('Rejection Return Note Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rejectionReturnNoteService->delete($rejectionReturnNote);
        return redirect()->route('rejection-return-notes.index')->with('success', 'Rejection Return Note deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $rejection = $this->rejectionReturnNoteService->createCode($companyId);
        return response()->json(['rejection' => $rejection]);
    }
}
