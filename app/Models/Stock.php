<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'raw_material_item_id', 'batch_id', 'goods_receiving_id', 'finished_goods_receiving_id', 'store_issue_requisition_id', 'rejection_return_note_id', 'left_over_note_id', 'quantity', 'unit', 'unit_price', 'total', 'company_id', 'created_by', 'updated_by'];

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
            ->whereNull('stocks.rejection_return_note_id')
            ->whereNull('stocks.left_over_note_id');
    }
}
