<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceivingVendorBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_receiving_id',
        'item_index',
        'bill_no',
        'bill_date',
        'amount',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the goods receiving note that owns the vendor bill.
     */
    public function goodsReceiving()
    {
        return $this->belongsTo(GoodsReceiving::class);
    }

    /**
     * Get the item description based on item_index
     */
    public function getItemDescriptionAttribute()
    {
        if ($this->goodsReceiving && isset($this->goodsReceiving->items[$this->item_index])) {
            return $this->goodsReceiving->items[$this->item_index]->description ?? "Item " . ($this->item_index + 1);
        }
        return "Item " . ($this->item_index + 1);
    }
}
