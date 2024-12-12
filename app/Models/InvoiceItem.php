<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'product_variation_id', 'raw_material_item_id', 'product_group_id', 'batch_id', 'unit', 'unit_price', 'quantity', 'tax_rate', 'discount_type', 'discount','total_amount'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function getItemAttribute()
    {
        return $this->product_id
            ? $this->product
            : $this->rawMaterialItem;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}