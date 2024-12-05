<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeftOverNote extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'product_id', 'batch_id', 'department_id', 'store_issue_requisition_id', 'company_id', 'created_by', 'updated_by'];

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
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
    public function storeIssueRequisition()
    {
        return $this->belongsTo(StoreIssueRequisition::class);
    }
    
    public function items()
    {
        return $this->hasMany(LeftOverNoteItem::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    
}
