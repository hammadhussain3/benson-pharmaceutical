<?php

namespace App\Http\Controllers;

use App\Models\StoreIssueRequisition;
use App\Models\ProductVariation;
use App\Models\ReceiptVoucher;
use App\Models\LeftOverNote;
use App\Models\ProductGroup;
use App\Models\InvoiceItem;
use App\Models\CreditNote;
use App\Models\Invoice;
use App\Models\Party;
use App\Models\Batch;
use App\Services\FinishedGoodsReceivingService;
use App\Services\StoreIssueRequisitionService;
use App\Services\ProductVariationService;
use App\Services\RawMaterialItemService;
use App\Services\FranchiseService;
use App\Services\CountryService;
use App\Services\InvoiceService;
use App\Services\StockService;
use App\Services\BatchService;
use App\Services\PartyService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $finishedGoodsReceivingService;
    protected $storeIssueRequisitionService;
    protected $productVariationService;
    protected $rawMaterialItemService;
    protected $franchiseService;
    protected $invoiceService;
    protected $countryService;
    protected $stockService;
    protected $batchService;
    protected $partyService;

    public function __construct(StockService $stockService, 
        InvoiceService $invoiceService, 
        FinishedGoodsReceivingService $finishedGoodsReceivingService, 
        StoreIssueRequisitionService $storeIssueRequisitionService,  
        ProductVariationService $productVariationService,
        RawMaterialItemService $rawMaterialItemService,
        FranchiseService $franchiseService,
        CountryService $countryService,
        PartyService $partyService,
        BatchService $batchService,)
    {
        $this->finishedGoodsReceivingService = $finishedGoodsReceivingService;
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->productVariationService = $productVariationService;
        $this->rawMaterialItemService = $rawMaterialItemService;
        $this->franchiseService = $franchiseService;
        $this->invoiceService = $invoiceService;
        $this->countryService = $countryService;
        $this->stockService = $stockService;
        $this->batchService = $batchService;
        $this->partyService = $partyService;
    }

    public function balanceReport()
    {
        $stocks = $this->stockService->currentBalanceReport();
        return view('admin.reports.balance-report',compact('stocks'));
    }

    public function purchaseItems(Request $request)
    {
        // $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        // $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $status = $request->has('status') ? $request->input('status') : null;
        $days_filter = $request->has('days_filter') ? $request->input('days_filter') : null;
        $urgent = $request->has('urgent') ? $request->input('urgent') : null;
        $type = $request->has('type') ? $request->input('type') : null;
        $purchaseItems = $this->invoiceService->getOnlyPurchaseItems($status);
        if ($type === 'purchase-order') {
            $purchaseItems = $purchaseItems->sortBy(fn($item) => $item->invoice->code);
        } elseif ($type === 'items-name') {
            $purchaseItems = $purchaseItems->sortBy('title');
        } elseif ($type === 'vendor') {
            $purchaseItems = $purchaseItems->sortBy(fn($item) => $item->invoice->party->name);
        } elseif ($type === 'req-date') {
            $purchaseItems = $purchaseItems->sortBy(fn($item) => $item->invoice->required_date);
        } elseif ($type === 'days-remaining') {
            $purchaseItems = $purchaseItems->sortBy(fn($item) => now()->diffInDays(\Carbon\Carbon::parse($item->invoice->required_date), false));
        }

        if ($days_filter === 'overdue') {
            $purchaseItems = $purchaseItems->filter(function ($item) {
                $requiredDate = Carbon::parse($item->invoice->required_date)->startOfDay();
                $remainingDays = now()->startOfDay()->diffInDays($requiredDate, false);
                return $remainingDays < 0;
            });
        } elseif ($days_filter === 'remaining') {
            $purchaseItems = $purchaseItems->filter(function ($item) {
                $requiredDate = Carbon::parse($item->invoice->required_date)->startOfDay();
                $remainingDays = now()->startOfDay()->diffInDays($requiredDate, false);
                return $remainingDays >= 0;
            });
        }

        if ($urgent === '1') {
            $purchaseItems = $purchaseItems->filter(function ($item) {
                return $item->invoice->is_urgent == 1;
            });
        } elseif ($urgent === '0') {
            $purchaseItems = $purchaseItems->filter(function ($item) {
                return $item->invoice->is_urgent == 0;
            });
        }

        // dd($purchaseItems->toArray());
        return view('admin.reports.purchase-items',compact('purchaseItems','status', 'days_filter', 'type', 'urgent'));
    }

    public function purchaseOrderAppraisal(Request $request)
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

    public function stockBinCard(Request $request)
    {
        $productParam = $request->input('product');
        $from_date = $request->has('from_date') ? $request->input('from_date') : now()->subDays(30)->format('Y-m-d');
        $to_date = $request->has('to_date') ? $request->input('to_date') : now()->format('Y-m-d');
        $rawMaterials = $this->rawMaterialItemService->getAllRawMaterialItems();
        $finalProducts = $this->productVariationService->getAllProductVariations();
        $stockBinCards = null;
        $productType = null;
        $product = null;

        if (str_starts_with($productParam, 'raw_')) {
            $productType = 0;
            $id = str_replace('raw_', '', $productParam);
            $product = $this->rawMaterialItemService->getRawMaterialItemById($id);
            $stockBinCards = $this->stockService->stockBinCard(null, $id, null, $from_date, $to_date);
        } elseif (str_starts_with($productParam, 'product_')) {
            $productType = 1;
            $id = str_replace('product_', '', $productParam);
            $product = $this->productVariationService->getProductVariationById($id);
            $stockBinCards = $this->stockService->stockBinCard(null, null, $id, $from_date, $to_date);
        }

        return view('admin.reports.bin-card', compact('stockBinCards', 'product', 'from_date', 'to_date', 'rawMaterials', 'finalProducts', 'productType'));
    }

    public function batchReport(Request $request)
    {
        $products = $this->productVariationService->getAllProductVariations();
        $finalProduct = $request->has('product') 
            ? $this->productVariationService->getProductVariationById($request->input('product')) 
            : $this->productVariationService->getAllProductVariations()->first();

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

        return view('admin.reports.product-variant-batch-report', compact('items', 'from_date', 'to_date', 'array','products', 'finalProduct'));
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

    public function customerAging(Request $request)
    {
        $party = $request->has('party') 
            ? $this->partyService->getPartyById($request->input('party')) 
            : $this->partyService->getAllParties()->first();

        $from_date = $request->has('from_date') 
            ? $request->input('from_date') 
            : now()->subDays(30)->format('Y-m-d');

        $to_date = $request->has('to_date') 
            ? $request->input('to_date') 
            : now()->format('Y-m-d');

        $invoices = Invoice::where('party_id', $party->id)->orderBy('payment_deadline', 'asc')->get();

        $partyList = $this->partyService->getAllParties();

        return view('admin.reports.customer-aging', compact('party', 'from_date', 'to_date', 'invoices', 'partyList'));
    }

    public function franchiserSales(Request $request)
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

        // Check if the date range is greater than 12 months
        $fromDate = Carbon::parse($from_date);
        $toDate = Carbon::parse($to_date);
        $monthDiff = $fromDate->diffInMonths($toDate);

        if ($monthDiff > 12) {
            return back()->withErrors(['date_range' => 'The date range cannot exceed 12 months.']);
        }

        $parties = $this->franchiseService->getAllFranchises();

        // Fetching the invoices
        $invoices = InvoiceItem::whereHas('invoice', function($query) use ($franchiser, $from_date, $to_date) {
            $query->where('party_id', $franchiser->id)
                ->whereBetween('invoice_date', [$from_date, $to_date]);
        })->get();

        $product_group_sales = []; // To store the required data structure

        // Generate all months between from_date and to_date
        $all_months = [];
        $current_date = Carbon::parse($from_date);

        while ($current_date->lte($to_date)) {
            $all_months[] = $current_date->format('m-Y');
            $current_date->addMonth();
        }

        foreach ($invoices as $invoice) {
            // Get the month in the format MM-YYYY
            $month = Carbon::parse($invoice->invoice->invoice_date)->format('m-Y');
            $product_group_id = $invoice->product_group_id;
            $product_group_name = $invoice->productGroup->name ?? null;
            $quantity = $invoice->quantity;

            // Initialize the product_group_id if it doesn't exist in the product_group_sales array
            if (!isset($product_group_sales[$product_group_id])) {
                $product_group_sales[$product_group_id] = [
                    'product_group_name' => $product_group_name,  // Store product group name
                    'monthly_quantity' => []  // Initialize the array for monthly quantities
                ];
            }

            // Check if the month already exists for this product group, if not add it
            $found = false;
            foreach ($product_group_sales[$product_group_id]['monthly_quantity'] as &$month_data) {
                if ($month_data['month'] == $month) {
                    // Add the quantity to the existing month for this product group
                    $month_data['quantity'] += $quantity;
                    $found = true;
                    break;  // Exit the loop once the month is found
                }
            }

            // If the month was not found, add it to the monthly_quantity array
            if (!$found) {
                $product_group_sales[$product_group_id]['monthly_quantity'][] = [
                    'month' => $month,
                    'quantity' => $quantity
                ];
            }
        }

        // Ensure that every product group has data for all months in the range (even if quantity is 0)
        foreach ($product_group_sales as $product_group_id => &$sales_data) {
            // Sort monthly quantities by month in ascending order
            usort($sales_data['monthly_quantity'], function ($a, $b) {
                return strtotime($a['month']) - strtotime($b['month']);
            });

            // Fill missing months with 0 quantity
            foreach ($all_months as $month) {
                $month_found = false;
                foreach ($sales_data['monthly_quantity'] as &$month_data) {
                    if ($month_data['month'] == $month) {
                        $month_found = true;
                        break;
                    }
                }
                // If the month does not exist for this product group, add it with 0 quantity
                if (!$month_found) {
                    $sales_data['monthly_quantity'][] = [
                        'month' => $month,
                        'quantity' => 0
                    ];
                }
            }

            // Sort again after filling missing months to keep the order consistent
            usort($sales_data['monthly_quantity'], function ($a, $b) {
                return strtotime($a['month']) - strtotime($b['month']);
            });
        }

        return view('admin.reports.franchiser-sales', compact('franchiser', 'from_date', 'to_date', 'parties', 'all_months', 'product_group_sales'));
    }

    public function countryQuantitySales(Request $request)
    {
        $countries = $this->countryService->getAllCountries();

        $country = $request->has('country') 
            ? $this->countryService->getCountryById($request->input('country')) 
            : $this->countryService->getAllCountries()->first();

        $franchisers = Party::where('is_distributor', '1')
            ->where('country_id', $country->id)
            ->get();

        $from_date = $request->has('from_date') 
            ? $request->input('from_date') 
            : now()->subDays(30)->format('Y-m-d');

        $to_date = $request->has('to_date') 
            ? $request->input('to_date') 
            : now()->format('Y-m-d');

        // Check if the date range is greater than 12 months
        $fromDate = Carbon::parse($from_date);
        $toDate = Carbon::parse($to_date);
        $monthDiff = $fromDate->diffInMonths($toDate);

        if ($monthDiff > 12) {
            return back()->withErrors(['date_range' => 'The date range cannot exceed 12 months.']);
        }

        $franchiser_sales = []; // To store the required data structure
        $all_product_groups = []; // To store unique product groups

        foreach ($franchisers as $franchiser) {
            $invoices = InvoiceItem::whereHas('invoice', function ($query) use ($franchiser, $from_date, $to_date) {
                $query->where('party_id', $franchiser->id)
                    ->whereBetween('invoice_date', [$from_date, $to_date]);
            })->get();

            $product_group_sales = [];

            foreach ($invoices as $invoice) {
                $product_group_id = $invoice->product_group_id;
                $product_group_name = $invoice->productGroup->name ?? null;
                $quantity = $invoice->quantity;

                // Add product group to the list of all unique product groups
                if (!in_array($product_group_id, $all_product_groups)) {
                    $all_product_groups[] = $product_group_id;
                }

                if (!isset($product_group_sales[$product_group_id])) {
                    $product_group_sales[$product_group_id] = [
                        'product_group_id' => $product_group_id,
                        'product_group_name' => $product_group_name,
                        'quantity' => 0,
                    ];
                }

                $product_group_sales[$product_group_id]['quantity'] += $quantity;
            }

            // Append franchiser data
            $franchiser_sales[] = [
                'franchiser_id' => $franchiser->id,
                'franchiser_name' => $franchiser->name,
                'franchiser_sales' => array_values($product_group_sales), // Reset array keys
            ];
        }

        // Get all product groups' data in the right order
        $all_product_groups = ProductGroup::whereIn('id', $all_product_groups)->get();

        return view('admin.reports.country-quantity-sales', compact('country', 'from_date', 'to_date', 'franchiser_sales', 'countries', 'all_product_groups'));
    }

    public function countryAmountSales(Request $request)
    {
        $countries = $this->countryService->getAllCountries();

        $country = $request->has('country') 
            ? $this->countryService->getCountryById($request->input('country')) 
            : $this->countryService->getAllCountries()->first();

        $franchisers = Party::where('is_distributor', '1')
            ->where('country_id', $country->id)
            ->get();

        $from_date = $request->has('from_date') 
            ? $request->input('from_date') 
            : now()->subDays(30)->format('Y-m-d');

        $to_date = $request->has('to_date') 
            ? $request->input('to_date') 
            : now()->format('Y-m-d');

        // Check if the date range is greater than 12 months
        $fromDate = Carbon::parse($from_date);
        $toDate = Carbon::parse($to_date);
        $monthDiff = $fromDate->diffInMonths($toDate);

        if ($monthDiff > 12) {
            return back()->withErrors(['date_range' => 'The date range cannot exceed 12 months.']);
        }

        $franchiser_sales = []; // To store the required data structure
        $all_product_groups = []; // To store unique product groups

        foreach ($franchisers as $franchiser) {
            $invoices = InvoiceItem::whereHas('invoice', function ($query) use ($franchiser, $from_date, $to_date) {
                $query->where('party_id', $franchiser->id)
                    ->whereBetween('invoice_date', [$from_date, $to_date]);
            })->get();

            $product_group_sales = [];

            foreach ($invoices as $invoice) {
                $product_group_id = $invoice->product_group_id;
                $product_group_name = $invoice->productGroup->name ?? null;
                $amount = $invoice->total_amount;

                // Add product group to the list of all unique product groups
                if (!in_array($product_group_id, $all_product_groups)) {
                    $all_product_groups[] = $product_group_id;
                }

                if (!isset($product_group_sales[$product_group_id])) {
                    $product_group_sales[$product_group_id] = [
                        'product_group_id' => $product_group_id,
                        'product_group_name' => $product_group_name,
                        'amount' => 0,
                    ];
                }

                $product_group_sales[$product_group_id]['amount'] += $amount;
            }

            // Append franchiser data
            $franchiser_sales[] = [
                'franchiser_id' => $franchiser->id,
                'franchiser_name' => $franchiser->name,
                'franchiser_sales' => array_values($product_group_sales), // Reset array keys
            ];
        }

        // Get all product groups' data in the right order
        $all_product_groups = ProductGroup::whereIn('id', $all_product_groups)->get();

        return view('admin.reports.country-amount-sales', compact('country', 'from_date', 'to_date', 'franchiser_sales', 'countries', 'all_product_groups'));
    }
}