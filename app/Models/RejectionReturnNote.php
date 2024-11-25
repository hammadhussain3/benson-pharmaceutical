<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReturnNote extends Model
{
    use HasFactory;
    
    protected $fillable = ['party_id', 'invoice_id', 'supplier_bill_no', 'batch_id', 'store_issue_requisition_id', 'company_id', 'created_by', 'updated_by'];

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

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    
}
