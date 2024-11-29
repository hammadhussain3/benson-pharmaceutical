<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Services\FinishedGoodsReceivingService;
use App\Services\StoreIssueRequisitionService;
use App\Services\ProductVariationService;
use App\Services\InvoiceService;
use App\Services\StockService;
use App\Services\BatchService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $finishedGoodsReceivingService;
    protected $storeIssueRequisitionService;
    protected $productVariationService;
    protected $invoiceService;
    protected $stockService;
    protected $batchService;

    public function __construct(StockService $stockService, InvoiceService $invoiceService, FinishedGoodsReceivingService $finishedGoodsReceivingService, StoreIssueRequisitionService $storeIssueRequisitionService, BatchService $batchService, ProductVariationService $productVariationService)
    {
        $this->finishedGoodsReceivingService = $finishedGoodsReceivingService;
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->productVariationService = $productVariationService;
        $this->invoiceService = $invoiceService;
        $this->stockService = $stockService;
        $this->batchService = $batchService;
    }

    public function balanceReport()
    {
        $stocks = $this->stockService->currentBalanceReport();
        return view('admin.reports.balance-report',compact('stocks'));
    }

    public function purchaseItems(Request $request)
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

    public function consumptionReport()
    {
        $consumptionReport = $this->storeIssueRequisitionService->getConsumptionReport();
        return view('admin.reports.consumption-report',compact('consumptionReport'));
    }

    public function batchBalanceReport()
    {
        $batchBalanceReport = $this->batchService->getBatchesReport();
        $batchBalanceReport = array_filter($batchBalanceReport, function ($product) {
            return $product['quantity'] > 0 || 
                   collect($product['batches'])->contains(function ($batch) {
                       return $batch['batch_balance'] > 0;
                   });
        });
        return view('admin.reports.batch-report',compact('batchBalanceReport'));
    }

    public function batchTrackReport($id)
    {
        $batchTrackReport = $this->batchService->getBatchTrackReport($id);
        return view('admin.reports.batch-track-report',compact('batchTrackReport'));
    }

    public function costingVoucher($id)
    {
        $costingVoucher = $this->batchService->getCostingVoucher($id);
        $batch = Batch::findOrFail($id);
        return view('admin.reports.costing-voucher',compact('costingVoucher', 'batch'));
    }
}
