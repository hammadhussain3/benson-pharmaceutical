<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreIssueRequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = ['store_issue_requisition_id', 'product_id', 'raw_material_item_id', 'product_variation_id', 'quantity', 'unit', 'unit_price', 'total'];

    public function store_issue_requisition()
    {
        return $this->belongsTo(StoreIssueRequisition::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function raw_material_item()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
