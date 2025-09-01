<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GoodsReceivingItem extends Model
{
    protected $fillable = ['goods_receiving_id', 'product_id', 'raw_material_item_id', 'code', 'description', 'batch', 'mfg_date', 'exp_date', 'quantity_ordered', 'quantity_received', 'balance_receivable', 'unit', 'unit_price', 'total_amount', 'last_goods_receiving_id', 'created_by', 'updated_by'];

    protected static function booted()
    {
        $updateInvoiceStatus = function ($item) {
            $grn = $item->goodsReceiving;
            if (! $grn || ! $grn->invoice) return;

            $invoice = $grn->invoice;
            $invoiceItems = $invoice->items;

            $allComplete = true;
            $anyReceived = false;
            $totalRequiredQty = 0;
            $totalReceivedQty = 0;

            foreach ($invoiceItems as $invItem) {
                $requiredQty = $invItem->quantity;
                $totalRequiredQty += $requiredQty;

                $receivedQty = GoodsReceivingItem::whereHas('goodsReceiving', function ($q) use ($invoice) {
                    $q->where('invoice_id', $invoice->id);
                })->where('raw_material_item_id', $invItem->raw_material_item_id)
                ->sum('balance_receivable');

                $totalReceivedQty += $receivedQty;

                if ($receivedQty >= $requiredQty) {
                    $anyReceived = true;
                } elseif ($receivedQty > 0) {
                    $allComplete = false;
                    $anyReceived = true;
                } else {
                    $allComplete = false;
                }
            }

            // Determine status based on GRN completion and due date
            $currentDate = Carbon::now();
            $requiredDate = Carbon::parse($invoice->required_date);
            $isOverdue = $currentDate->gt($requiredDate);

            if ($allComplete && $totalReceivedQty >= $totalRequiredQty) {
                // If GRN for full qty is made – COMPLETED
                $invoice->status = 'completed';
            } elseif ($anyReceived && $totalReceivedQty > 0 && $totalReceivedQty < $totalRequiredQty) {
                // If GRN for partial qty is made – PARTIALLY COMPLETE
                $invoice->status = 'partial';
            } elseif (!$anyReceived && $totalReceivedQty == 0) {
                // If GRN is not made at all
                if ($isOverdue) {
                    // If GRN is not made at all and due date has passed – DELAY
                    $invoice->status = 'delay';
                } else {
                    // If GRN is not made at all and due date hasn't passed – PENDING
                    $invoice->status = 'pending';
                }
            } else {
                // Fallback to pending
                $invoice->status = 'pending';
            }

            $invoice->save();
        };

        static::created($updateInvoiceStatus);
        static::updated($updateInvoiceStatus);
        static::deleted($updateInvoiceStatus);
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