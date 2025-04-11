<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReturnNote extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'party_id', 'invoice_id', 'supplier_bill_no', 'batch_id', 'store_issue_requisition_id', 'is_approved', 'company_id', 'created_by', 'updated_by'];

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
    
    public function storeIssueRequisition()
    {
        return $this->belongsTo(StoreIssueRequisition::class);
    }
    
    public function items()
    {
        return $this->hasMany(RejectionReturnNoteItem::class);
    }    
}