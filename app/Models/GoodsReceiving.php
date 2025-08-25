<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiving extends Model
{
    protected $fillable = ['code', 'invoice_id', 'party_id', 'supplier_name', 'supplier_code', 'supplier_bill_no', 'is_approved', 'company_id', 'sales_tax', 'adv_tax', 'total_amount', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    
    public function items()
    {
        return $this->hasMany(GoodsReceivingItem::class);
    }

    public function vendor_bills()
    {
        return $this->hasMany(GoodsReceivingVendorBill::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}