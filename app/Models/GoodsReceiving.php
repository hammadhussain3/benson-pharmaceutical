<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiving extends Model
{
    protected $fillable = ['code', 'invoice_id', 'party_id', 'supplier_bill_no', 'company_id', 'sales_tax', 'adv_tax', 'total_amount'];

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

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
