<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'prefix', 'party_id', 'required_date', 'is_urgent', 'company_id', 'status', 'discount_type', 'discount', 'invoice_tax_rate', 'total_invoice_tax', 'items_cost_with_tax', 'items_cost_without_tax', 'shipping_cost', 'paid_amount', 'returned_amount', 'due_amount', 'discount_type', 'discount', 'total_amount', 'payment_status', 'note', 'payment_deadline', 'invoice_date', 'created_by', 'updated_by'];

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
    
}
