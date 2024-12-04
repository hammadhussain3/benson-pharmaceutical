<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnItem extends Model
{
    use HasFactory;

    protected $fillable = ['sales_return_id', 'product_variation_id', 'batch_id', 'unit', 'unit_price', 'quantity', 'tax_rate', 'discount_type', 'discount','total_amount'];

    public function salesReturn()
    {
        return $this->belongsTo(SalesReturn::class);
    }
    
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
