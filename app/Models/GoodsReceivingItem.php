<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceivingItem extends Model
{
    protected $fillable = ['goods_receiving_id', 'product_id', 'raw_material_item_id', 'batch_id', 'quantity_ordered', 'quantity_received', 'balance_receivable', 'unit', 'unit_price', 'total_amount', 'last_goods_receiving_id', 'created_by', 'updated_by'];

    protected static function booted()
    {
        static::created(function ($item) {
            $grn = $item->goodsReceiving;
            if (! $grn || ! $grn->invoice) return;
    
            $invoice = $grn->invoice;
            $invoiceItems = $invoice->items;
    
            $allComplete = true;
            $anyReceived = false;
    
            foreach ($invoiceItems as $invItem) {
                $requiredQty = $invItem->quantity;
    
                $receivedQty = GoodsReceivingItem::whereHas('goodsReceiving', function ($q) use ($invoice) {
                    $q->where('invoice_id', $invoice->id);
                })->where('raw_material_item_id', $invItem->raw_material_item_id)
                  ->sum('balance_receivable');
                  
                if ($receivedQty >= $requiredQty) {
                    $anyReceived = true;
                } elseif ($receivedQty > 0) {
                    $allComplete = false;
                    $anyReceived = true;
                } else {
                    $allComplete = false;
                }
            }
    
            if ($allComplete) {
                $invoice->status = 'completed';
            } elseif ($anyReceived) {
                $invoice->status = 'partial';
            } else {
                $invoice->status = 'pending';
            }
    
            $invoice->save();
        });
    }

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