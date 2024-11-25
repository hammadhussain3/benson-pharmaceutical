<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeftOverNoteItem extends Model
{
    use HasFactory;

    protected $fillable = ['left_over_note_id', 'raw_material_item_id', 'quantity', 'unit', 'unit_price', 'total', 'remarks'];

    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function leftOverNote()
    {
        return $this->belongsTo(LeftOverNote::class);
    }
}
