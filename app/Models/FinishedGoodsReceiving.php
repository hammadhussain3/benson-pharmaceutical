<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinishedGoodsReceiving extends Model
{
    protected $fillable = ['code', 'batch_id', 'product_id', 'company_id'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(FinishedGoodsReceivingItem::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public static function monthlyProduction($id = null)
    {
        $quantity = FinishedGoodsReceivingItem::where('product_variation_id', $id)->sum('quantity_received');
    }
}
