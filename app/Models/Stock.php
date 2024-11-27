<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'raw_material_item_id', 'product_variation_id', 'batch_id', 'goods_receiving_id', 'finished_goods_receiving_id', 'store_issue_requisition_id', 'left_over_note_id', 'quantity', 'unit', 'unit_price', 'total', 'company_id', 'created_by', 'updated_by'];

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
        return $query->leftJoin('products', 'stocks.product_id', '=', 'products.id')
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
    }

    public static function currentBalance()
    {
        $addQuantityWhenAllNull = self::whereNull('goods_receiving_id')
            ->whereNull('finished_goods_receiving_id')
            ->whereNull('store_issue_requisition_id')
            ->whereNull('left_over_note_id')
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $addQuantityWhenNotNull = self::where(function ($query) {
                $query->whereNotNull('goods_receiving_id')
                    ->orWhereNotNull('finished_goods_receiving_id')
                    ->orWhereNotNull('left_over_note_id');
            })
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $subtractQuantityWhenNotNull = self::where(function ($query) {
                $query->whereNotNull('store_issue_requisition_id');
            })
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $balances = [];

        // Process rows and update balances
        $processRows = function ($rows, $operation) use (&$balances) {
            foreach ($rows as $row) {
                $exists = false;

                foreach ($balances as $key => $balance) {
                    if (
                        $balance['product_id'] === $row->product_id &&
                        $balance['raw_material_item_id'] === $row->raw_material_item_id &&
                        $balance['product_variation_id'] === $row->product_variation_id
                    ) {
                        $balances[$key]['balance'] += ($operation === '+') ? $row->total_quantity : -$row->total_quantity;
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $balances[] = [
                        'product_id' => $row->product_id,
                        'raw_material_item_id' => $row->raw_material_item_id,
                        'product_variation_id' => $row->product_variation_id,
                        'balance' => ($operation === '+') ? $row->total_quantity : -$row->total_quantity
                    ];
                }
            }
        };

        // Update balances
        $processRows($addQuantityWhenAllNull, '+');
        $processRows($addQuantityWhenNotNull, '+');
        $processRows($subtractQuantityWhenNotNull, '-');

        return array_values($balances);
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
            ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id')
            ->select('product_id', 'raw_material_item_id', 'product_variation_id', DB::raw('SUM(quantity) as total_quantity'))
            ->get();

        $addQuantityWhenNotNull = (clone $query)
            ->where(function ($q) {
                $q->whereNotNull('goods_receiving_id')
                    ->orWhereNotNull('finished_goods_receiving_id')
                    ->orWhereNotNull('left_over_note_id');
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
}
