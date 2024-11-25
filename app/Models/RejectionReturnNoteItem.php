<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReturnNoteItem extends Model
{
    use HasFactory;

    protected $fillable = ['rejection_return_note_id', 'raw_material_item_id', 'product_id', 'quantity', 'unit', 'unit_price', 'total', 'remarks'];

    public function rejectionReturnNote()
    {
        return $this->belongsTo(RejectionReturnNote::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }
}
