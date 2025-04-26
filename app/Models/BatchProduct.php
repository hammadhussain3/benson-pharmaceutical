<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchProduct extends Model
{
    protected $fillable = [
        'batch_id',
        'product_variation_id',
        'quantity',
        'trade_price',
    ];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
