<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceivingItem extends Model
{
    protected $fillable = ['goods_receiving_id', 'product_id', 'raw_material_item_id', 'batch_id', 'quantity_ordered', 'quantity_received', 'balance_receivable', 'unit', 'unit_price', 'total_amount', 'last_goods_receiving_id', 'created_by', 'updated_by'];

    public function goodsReceiving()
    {
        return $this->belongsTo(GoodsReceiving::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function lastGoodsReceiving()
    {
        return $this->belongsTo(GoodsReceivingItem::class, 'last_goods_receiving_id');
    }

    public function getItemAttribute()
    {
        return $this->product_id
            ? $this->product
            : $this->rawMaterialItem;
    }
    
}
