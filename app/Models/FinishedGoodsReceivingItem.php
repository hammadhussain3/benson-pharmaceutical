<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinishedGoodsReceivingItem extends Model
{
    protected $fillable = ['finished_goods_receiving_id', 'product_variation_id', 'quantity_received', 'unit', 'unit_price', 'total'];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function finishedGoodsReceiving()
    {
        return $this->belongsTo(FinishedGoodsReceiving::class);
    }    
}
