<?php

namespace App\Http\Controllers;

use App\Services\FinishedGoodsReceivingService;
use App\Services\InvoiceService;
use App\Services\StockService;

class ReportController extends Controller
{
    protected $finishedGoodsReceivingService;
    protected $invoiceService;
    protected $stockService;

    public function __construct(StockService $stockService, InvoiceService $invoiceService, FinishedGoodsReceivingService $finishedGoodsReceivingService)
    {
        $this->finishedGoodsReceivingService = $finishedGoodsReceivingService;
        $this->invoiceService = $invoiceService;
        $this->stockService = $stockService;
    }

    public function balanceReport()
    {
        $stocks = $this->stockService->currentBalanceReport();
        return view('admin.reports.balance-report',compact('stocks'));
    }

    public function purchaseItems()
    {
        $purchaseItems = $this->invoiceService->getOnlyPurchaseItems()->sortBy('item_code');
        return view('admin.reports.purchase-items',compact('purchaseItems'));
    }

    public function purchaseRequisitions()
    {
        $purchaseRequisitions = $this->invoiceService->getOnlyPurchaseRequisitions();
        return view('admin.reports.purchase-requisitions',compact('purchaseRequisitions'));
    }

    public function requirementReport()
    {
        $requirementReport = $this->invoiceService->getRequirementForInvoice();
        return view('admin.reports.requirement-report',compact('requirementReport'));
    }

    public function productionReport()
    {
        $productionReport = $this->finishedGoodsReceivingService->getMonthlyFinishedProductReport();
        return view('admin.reports.production-report',compact('productionReport'));
    }
}
