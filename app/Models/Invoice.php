<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'prefix', 'party_id', 'order_number', 'order_date', 'required_date', 'is_urgent', 'company_id', 'status', 'discount_type', 'discount', 'invoice_tax_rate', 'total_invoice_tax', 'items_cost_with_tax', 'items_cost_without_tax', 'shipped_via', 'shipping_cost', 'paid_amount', 'returned_amount', 'due_amount', 'discount_type', 'discount', 'total_amount', 'payment_status', 'note', 'payment_deadline', 'invoice_date', 'is_approved', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });

        static::saving(function ($model) {
            if ($model->total_amount == $model->due_amount) {
                $model->payment_status = 'paid';
            } elseif ($model->due_amount > 0 && $model->due_amount < $model->total_amount) {
                $model->payment_status = 'partial';
            } else {
                $model->payment_status = 'unpaid';
            }
        });
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    
    public function goodsReceivings()
    {
        return $this->hasMany(GoodsReceiving::class);
    }
}