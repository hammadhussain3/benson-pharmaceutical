<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\FinishedGoodsReceivingItem;
use App\Models\LeftOverNoteItem;
use App\Models\ProductVariation;
use App\Models\Stock;
use App\Models\StoreIssueRequisitionItem;
use Illuminate\Support\Facades\DB;

class BatchService
{
    public function getAllBatches()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $batches = Batch::orderBy('batch_no', 'asc')->get();
        } else {
            $batches = Batch::where('company_id', auth()->user()->employee->company_id)->orderBy('batch_no', 'asc')->get();
        }
        return $batches;
    }

    public function createBatch(array $data)
    {
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];

        $batch = Batch::create($data);

        if ($data['items']) {
            foreach ($data['items'] as $key => $value) {
                $value['product_variation_id'] = $value['product_variation'];
                $value['batch_id'] = $batch->id;
                $batch->items()->create($value);
            }
        }

        return $batch;
    }

    public function updateBatch(Batch $batch, array $data)
    {
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];
        $batch->update($data);
        $batch->items()->delete();
        if ($data['items']) {
            foreach ($data['items'] as $key => $value) {
                $value['product_variation_id'] = $value['product_variation'];
                $value['batch_id'] = $batch->id;
                $batch->items()->create($value);
            }
        }
        return $batch;
    }

    public function deleteBatch(Batch $batch)
    {
        return $batch->delete();
    }

    public function getBatchById($id)
    {
        return Batch::findOrFail($id);
    }

    public function getBatchesReport()
    {
        $batchProducts = [];
        $products = ProductVariation::with(['product.batches'])->get();

        if (!auth()->user()->hasRole('Superadmin')) {
            $products->where('company_id', auth()->user()->employee->company_id);
        }

        $products->each(function ($product) use (&$batchProducts) {
            // Fetch the latest Finished Goods Receiving Item
            $finishedGoodsReceivingItem = FinishedGoodsReceivingItem::where('product_variation_id', $product->id)->latest()->first();

            // Initialize product details
            $productData = [
                'id' => $product->id,
                'product_id' => $product->product_id,
                'code' => $product->product->code,
                'name' => $product->product->name,
                'quantity' => $product->balance(),
                'unit' => $finishedGoodsReceivingItem->unit ?? 'No',
                'unit_price' => $finishedGoodsReceivingItem->unit_price ?? 0,
                'batches' => [],
            ];

            // Query stock data grouped by batch_id
            $batchBalances = Stock::where('product_variation_id', $product->id)
                ->groupBy('batch_id')
                ->select('batch_id', DB::raw('SUM(quantity) as total_quantity'))
                ->get();

            $batchDetails = [];

            // Loop through batches and calculate balances
            $product->product->batches->each(function ($batch) use (&$batchDetails, $batchBalances) {
                $batchBalance = $batchBalances->firstWhere('batch_id', $batch->id);

                $batchDetails[] = [
                    'batch_id' => $batch->id,
                    'batch_code' => $batch->batch_no,
                    'batch_balance' => $batchBalance->total_quantity ?? 0,
                    'mfg' => $batch->mfg_date,
                    'exp' => $batch->exp_date,
                ];
            });

            // Attach batch details to the product data
            $productData['batches'] = $batchDetails;
            $batchProducts[] = $productData;
        });

        return $batchProducts;
    }

    // public function getBatchTrackReport($id)
    // {
    //     $stockEntries = Stock::where('batch_id', $id)
    //         ->orderBy('created_at', 'asc') // Assuming you want chronological order
    //         ->get();

    //     if (!auth()->user()->hasRole('Superadmin')) {
    //         $stockEntries->where('company_id', auth()->user()->employee->company_id);
    //     }

    //     // Initialize the balance and structured data
    //     $balance = 0;
    //     $batchTrackReport = [];

    //     foreach ($stockEntries as $entry) {
    //         $entryData = [
    //             'date' => $entry->created_at->format('Y-m-d'), // Format the date
    //             'type' => $entry->finished_goods_receiving_id ? 'In' : ($entry->store_issue_requisition_id ? 'Out' : 'Unknown'),
    //             'quantity' => $entry->quantity,
    //             'balance' => 0, // Placeholder, will be updated below
    //         ];

    //         // Adjust balance based on type
    //         if ($entryData['type'] === 'In') {
    //             $balance += $entry->quantity;
    //         } elseif ($entryData['type'] === 'Out') {
    //             $balance -= $entry->quantity;
    //         }

    //         // Update the balance in the entry data
    //         $entryData['balance'] = $balance;

    //         // Append the entry to the report
    //         $batchTrackReport[] = $entryData;
    //     }

    //     echo "<pre>";
    //     print_r($batchTrackReport);
    //     exit;

    //     // Return the response
    //     return $batchTrackReport;
    // }

    public function getCostingVoucher($id)
    {
        $batchTrackReport = [];
        
        $leftoverNoteItems = LeftOverNoteItem::whereHas('leftOverNote', function ($query) use ($id) {
            $query->where('batch_id', $id);
        })->get();

        if (!auth()->user()->hasRole('Superadmin')) {
            $leftoverNoteItems->whereHas('leftOverNote', function ($query) {
                $query->where('company_id', auth()->user()->employee->company_id);
            });
        }

        if ($leftoverNoteItems) {
            foreach ($leftoverNoteItems as $item) {
                $batchTrackReport[] = [
                    'date' => $item->leftOverNote->created_at->format('Y-m-d'),
                    'type' => 'credit',
                    'doc_type' => 'LON',
                    'code' => $item->leftOverNote->code,
                    'product_code' => $item->rawMaterialItem->code,
                    'product_name' => $item->rawMaterialItem->name,
                    'unit' => $item->unit,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->quantity * $item->unit_price,
                ];
            }
        }

        $storeIssueRequisitionItems = StoreIssueRequisitionItem::whereHas('store_issue_requisition', function ($query) use ($id) {
            $query->where('batch_id', $id)->where('is_production', '1');
        })->get();

        if (!auth()->user()->hasRole('Superadmin')) {
            $storeIssueRequisitionItems->whereHas('store_issue_requisition', function ($query) {
                $query->where('company_id', auth()->user()->employee->company_id);
            });
        }

        if ($storeIssueRequisitionItems) {
            foreach ($storeIssueRequisitionItems as $item) {
                $batchTrackReport[] = [
                    'date' => $item->store_issue_requisition->created_at->format('Y-m-d'),
                    'type' => 'debit',
                    'doc_type' => 'SIR',
                    'code' => $item->store_issue_requisition->code,
                    'product_code' => $item->raw_material_item->code,
                    'product_name' => $item->raw_material_item->name,
                    'unit' => $item->unit,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->quantity * $item->unit_price,
                ];
            }
        }

        usort($batchTrackReport, function ($a, $b) {
            return strtotime($a['date']) <=> strtotime($b['date']);
        });

        return $batchTrackReport;
    }
}