<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'raw_material_item_id', 'product_variation_id', 'batch_id', 'goods_receiving_id', 'finished_goods_receiving_id', 'store_issue_requisition_id', 'left_over_note_id', 'sales_return_id', 'quantity', 'unit', 'unit_price', 'total', 'company_id', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function goodsReceiving()
    {
        return $this->belongsTo(GoodsReceiving::class);
    }

    public function finishedGoodsReceiving()
    {
        return $this->belongsTo(FinishedGoodsReceiving::class);
    }
    
    public function storeIssueRequisition()
    {
        return $this->belongsTo(StoreIssueRequisition::class);
    }

    public function rejectionReturnNote()
    {
        return $this->belongsTo(RejectionReturnNote::class);
    }
    
    public function leftOverNote()
    {
        return $this->belongsTo(LeftOverNote::class);
    }

    public function scopeOnlyManualStock($query)
    {
        $query->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('raw_material_items', 'stocks.raw_material_item_id', '=', 'raw_material_items.id')
            ->join('companies', 'stocks.company_id', '=', 'companies.id')
            ->select(
                'stocks.id as stock_id',
                'stocks.quantity',
                'stocks.unit',
                'stocks.unit_price',
                'stocks.total',
                'companies.name as company_name',
                DB::raw('COALESCE(products.name, raw_material_items.name) as name')
            )
            ->whereNull('stocks.goods_receiving_id')
            ->whereNull('stocks.finished_goods_receiving_id')
            ->whereNull('stocks.store_issue_requisition_id')
            ->whereNull('stocks.left_over_note_id');

        if (!auth()->user()->hasRole('Superadmin')) {
            $query->where('stocks.company_id', auth()->user()->employee->company_id);
        }

        return $query;
    }

    public static function currentBalance()
    {
        // Get ALL raw material items from master table
        $allRawMaterialItems = \App\Models\RawMaterialItem::select('id as raw_material_item_id', 'name', 'code', 'unit as item_unit', 'min_level', 'max_level')
            ->when(!auth()->user()->hasRole('Superadmin'), function ($query) {
                $query->where('company_id', auth()->user()->employee->company_id);
            })
            ->get();

        $balances = [];

        foreach ($allRawMaterialItems as $rawMaterialItem) {
            // Get stock balance for this raw material item
            $stockBalance = self::where('raw_material_item_id', $rawMaterialItem->raw_material_item_id)
                ->select(
                    DB::raw('SUM(CASE 
                        WHEN goods_receiving_id IS NOT NULL OR finished_goods_receiving_id IS NOT NULL OR left_over_note_id IS NOT NULL OR sales_return_id IS NOT NULL THEN quantity
                        WHEN store_issue_requisition_id IS NOT NULL THEN -quantity
                        WHEN goods_receiving_id IS NULL AND finished_goods_receiving_id IS NULL AND store_issue_requisition_id IS NULL AND left_over_note_id IS NULL AND sales_return_id IS NULL THEN quantity
                        ELSE 0
                    END) as total_quantity')
                )
                ->groupBy('raw_material_item_id')
                ->first();

            // If no stock record exists, set default values
            if (!$stockBalance) {
                $balances[] = [
                    'product_id' => null,
                    'raw_material_item_id' => $rawMaterialItem->raw_material_item_id,
                    'product_variation_id' => null,
                    'balance' => 0,
                    'unit' => $rawMaterialItem->unit,
                    'unit_price' => 0,
                    'name' => $rawMaterialItem->name,
                    'code' => $rawMaterialItem->code,
                    'item_unit' => $rawMaterialItem->item_unit,
                ];
            } else {
                $balances[] = [
                    'product_id' => null,
                    'raw_material_item_id' => $rawMaterialItem->raw_material_item_id,
                    'product_variation_id' => null,
                    'balance' => $stockBalance->total_quantity ?? 0,
                    'unit' => $rawMaterialItem->unit,
                    'unit_price' => 0, // Set unit_price to 0 as it's not in the stock query
                    'name' => $rawMaterialItem->name,
                    'code' => $rawMaterialItem->code,
                    'item_unit' => $rawMaterialItem->item_unit,
                ];
            }
        }

        return $balances;

    }

    public static function currentBalanceForItem($productId = null, $rawMaterialItemId = null, $productVariationId = null)
    {
        // Base query with filters
        $query = self::query();

        if ($productId !== null) {
            $query->where('product_id', $productId);
        }
        if ($rawMaterialItemId !== null) {
            $query->where('raw_material_item_id', $rawMaterialItemId);
        }
        if ($productVariationId !== null) {
            $query->where('product_variation_id', $productVariationId);
        }

        // Fetch data for additions and subtractions
        $addQuantityWhenAllNull = (clone $query)
            ->whereNull('goods_receiving_id')
            ->whereNull('finished_goods_receiving_id')
            ->whereNull('store_issue_requisition_id')
            ->whereNull('left_over_note_id')
            ->whereNull('sales_return_id')
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $addQuantityWhenNotNull = (clone $query)
            ->where(function ($q) {
                $q->whereNotNull('goods_receiving_id')
                    ->orWhereNotNull('finished_goods_receiving_id')
                    ->orWhereNotNull('left_over_note_id')
                    ->orWhereNotNull('sales_return_id');
            })
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $subtractQuantityWhenNotNull = (clone $query)
            ->where(function ($q) {
                $q->whereNotNull('store_issue_requisition_id');
            })
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        // Calculate the balance
        $balance = 0;

        $processRows = function ($rows, $operation) use (&$balance) {
            foreach ($rows as $row) {
                $quantity = $row->total_quantity;
                $balance += ($operation === '+') ? $quantity : -$quantity;
            }
        };

        $processRows($addQuantityWhenAllNull, '+');
        $processRows($addQuantityWhenNotNull, '+');
        $processRows($subtractQuantityWhenNotNull, '-');

        return [
            'product_id' => $productId,
            'raw_material_item_id' => $rawMaterialItemId,
            'product_variation_id' => $productVariationId,
            'balance' => $balance
        ];
    }

    public static function getAvailableFinishedGoodsByBatch()
    {
        $availableItems = DB::table('finished_goods_receiving_items as fgri')
            ->join('finished_goods_receivings as fgr', 'fgr.id', '=', 'fgri.finished_goods_receiving_id')
            ->leftJoin('invoice_items as ii', function($join) {
                $join->on('ii.product_variation_id', '=', 'fgri.product_variation_id')
                    ->on('ii.batch_id', '=', 'fgr.batch_id');
            })
            ->select(
                'fgri.product_variation_id',
                'fgr.batch_id',
                'fgri.quantity_received',
                DB::raw('COALESCE(SUM(ii.quantity), 0) as quantity_sold'),
                DB::raw('(fgri.quantity_received - COALESCE(SUM(ii.quantity), 0)) as quantity_available')
            )
            ->groupBy('fgri.id', 'fgr.id', 'fgri.product_variation_id', 'fgr.batch_id', 'fgri.quantity_received')
            ->having('quantity_available', '>', 0)
            ->get();

        return $availableItems;
    }
}
