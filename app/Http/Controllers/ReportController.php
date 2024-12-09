<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CreditNote;
use App\Models\Invoice;
use App\Models\LeftOverNote;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\RawMaterialItem;
use App\Models\ReceiptVoucher;
use App\Models\StoreIssueRequisition;
use App\Services\FinishedGoodsReceivingService;
use App\Services\StoreIssueRequisitionService;
use App\Services\ProductVariationService;
use App\Services\FranchiseService;
use App\Services\InvoiceService;
use App\Services\StockService;
use App\Services\BatchService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $finishedGoodsReceivingService;
    protected $storeIssueRequisitionService;
    protected $productVariationService;
    protected $franchiseService;
    protected $invoiceService;
    protected $stockService;
    protected $batchService;

    public function __construct(StockService $stockService, 
        InvoiceService $invoiceService, 
        FinishedGoodsReceivingService $finishedGoodsReceivingService, 
        StoreIssueRequisitionService $storeIssueRequisitionService, 
        BatchService $batchService, 
        ProductVariationService $productVariationService, 
        FranchiseService $franchiseService)
    {
        $this->finishedGoodsReceivingService = $finishedGoodsReceivingService;
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->productVariationService = $productVariationService;
        $this->franchiseService = $franchiseService;
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
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $status = $request->has('status') ? $request->input('status') : null;
        $purchaseItems = $this->invoiceService->getOnlyPurchaseItems($from_date, $to_date, $status)->sortBy('item_code');
        return view('admin.reports.purchase-items',compact('purchaseItems', 'from_date', 'to_date', 'status'));
    }

    public function purchaseRequisitions(Request $request)
    {
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $status = $request->has('status') ? $request->input('status') : null;
        $purchaseRequisitions = $this->invoiceService->getOnlyPurchaseRequisitions($from_date, $to_date, $status);
        return view('admin.reports.purchase-requisitions',compact('purchaseRequisitions','from_date', 'to_date', 'status'));
    }

    public function requirementReport()
    {
        $requirementReport = $this->invoiceService->getRequirementForInvoice();
        return view('admin.reports.requirement-report',compact('requirementReport'));
    }

    public function productionReport(Request $request)
    {
        $year = $request->has('year') ? $request->input('year') : now()->year;
        $productionReport = $this->finishedGoodsReceivingService->getMonthlyFinishedProductReport($year);
        return view('admin.reports.production-report',compact('productionReport', 'year'));
    }

    public function consumptionReport(Request $request)
    {
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $consumptionReport = $this->storeIssueRequisitionService->getConsumptionReport($from_date, $to_date);
        return view('admin.reports.consumption-report',compact('consumptionReport', 'from_date', 'to_date'));
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

    // public function batchTrackReport($id)
    // {
    //     $batchTrackReport = $this->batchService->getBatchTrackReport($id);
    //     return view('admin.reports.batch-track-report',compact('batchTrackReport'));
    // }

    public function costingVoucher($id)
    {
        $costingVoucher = $this->batchService->getCostingVoucher($id);
        $batch = Batch::findOrFail($id);
        return view('admin.reports.costing-voucher',compact('costingVoucher', 'batch'));
    }

    public function stockBinCardForFinalProduct(Request $request, $id)
    {
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $stockBinCards = $this->stockService->stockBinCard(null, null, $id, $from_date, $to_date);
        $finalProduct = ProductVariation::findOrFail($id);
        // echo "<pre>";
        // print_r($stockBinCards);
        // exit;
        return view('admin.reports.bin-card',compact('stockBinCards', 'finalProduct', 'from_date', 'to_date'));
    }

    public function stockBinCardForRawMaterial(Request $request, $id)
    {
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $stockBinCards = $this->stockService->stockBinCard(null, $id, null, $from_date, $to_date);
        $rawMaterialItem = RawMaterialItem::findOrFail($id);
        return view('admin.reports.bin-card',compact('stockBinCards', 'rawMaterialItem', 'from_date', 'to_date'));
    }

    public function stockBinCardForProducts(Request $request, $id)
    {
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $stockBinCards = $this->stockService->stockBinCard($id, null, null, $from_date, $to_date);
        $product = Product::findOrFail($id);
        return view('admin.reports.bin-card',compact('stockBinCards', 'product', 'from_date', 'to_date'));
    }

    public function batchReport(Request $request, $id)
    {
        $finalProduct = ProductVariation::findOrFail($id);

        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');

        $array = [];

        foreach ($finalProduct->product->batches as $key => $batch) {
            // $query = StoreIssueRequisition::where('batch_id', $batch->id)->where('product_id', $finalProduct->product_id)->whereHas('items');
            $result = StoreIssueRequisition::where('batch_id', $batch->id)
                ->where('product_id', $finalProduct->product_id)
                ->get();

            $totalItems = $result->sum(function ($requisition) {
                return $requisition->items->sum('total'); // Assuming 'total' is the field in the 'items' table
            });
            $totalItemRows = $result->sum(function ($requisition) {
                return $requisition->items->count(); // Counting rows in the 'items' relationship
            });
            $leftover = LeftOverNote::where('batch_id', $batch->id)
                ->where('product_id', $finalProduct->product_id)
                ->get();
            $totalleftover = $leftover->sum(function ($requisition) {
                return $requisition->items->sum('total'); // Assuming 'total' is the field in the 'items' table
            });

            $temp = $totalItems - $totalleftover;
            if ($temp > 0 && $totalItemRows > 0) {
                $avg = $temp / $totalItemRows; // Perform division if both are greater than 0
            } else {
                $avg = 0; // Default or alternative value when the condition is not met
            }
            

            $array[] = [
                "batch_id" => $batch->id,
                "product_id" => $finalProduct->product_id,
                "total" => $totalItems,
                "rows" => $totalItemRows,
                "leftover" => $totalleftover,
                "avgCost" => $avg,
            ];


        }


        $items = $finalProduct->product->batches->toArray();

        return view('admin.reports.product-variant-batch-report', compact('items', 'from_date', 'to_date','array'));
    }

    public function financialLedger(Request $request)
    {
        $franchiser = $request->has('franchiser') 
            ? $this->franchiseService->getFranchiseById($request->input('franchiser')) 
            : $this->franchiseService->getAllFranchises()->first();

        $from_date = $request->has('from_date') 
            ? $request->input('from_date') 
            : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') 
            ? $request->input('to_date') 
            : now()->format('Y-m-d');

        $parties = $this->franchiseService->getAllFranchises();

        $currentBalance = $franchiser->getBalanceBeforeDate($from_date);

        $financial_ledger[] = [
            'vr' => 'OB0000',
            'payment_method' => null,
            'type' => 'balance',
            'particular' => 'Opening Balance',
            'amount' => $currentBalance,
            'balance' => $currentBalance,
            'created_at' => Carbon::parse($from_date)->format('d M, Y'),
        ];

        $commercial_invoices = Invoice::where('type', 'sale')
            ->where('party_id', $franchiser->id)
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();

        foreach ($commercial_invoices as $invoice) {
            $currentBalance -= $invoice->total_amount;
            $financial_ledger[] = [
                'vr' => $invoice->code,
                'payment_method' => null,
                'type' => 'debit',
                'particular' => $invoice->party->name,
                'amount' => $invoice->total_amount,
                'balance' => $currentBalance,
                'created_at' => $invoice->created_at->format('d M, Y'),
            ];
        }

        $general_invoices = CreditNote::where('party_id', $franchiser->id)
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();

        foreach ($general_invoices as $invoice) {
            $currentBalance -= $invoice->total;
            $financial_ledger[] = [
                'vr' => $invoice->code,
                'payment_method' => null,
                'type' => 'debit',
                'particular' => $invoice->party->name,
                'amount' => $invoice->total,
                'balance' => $currentBalance,
                'created_at' => $invoice->created_at->format('d M, Y'),
            ];
        }

        $credit_vouchers = ReceiptVoucher::where('party_id', $franchiser->id)
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();

        foreach ($credit_vouchers as $voucher) {
            $currentBalance += $voucher->total;
            $financial_ledger[] = [
                'vr' => $voucher->code,
                'payment_method' => $voucher->payment_method,
                'type' => 'credit',
                'particular' => $voucher->party->name,
                'amount' => $voucher->total,
                'balance' => $currentBalance,
                'created_at' => $voucher->created_at->format('d M, Y'),
            ];
        }

        usort($financial_ledger, function ($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

        return view('admin.reports.financial-ledger', compact('franchiser', 'from_date', 'to_date', 'financial_ledger', 'parties'));
    }

}