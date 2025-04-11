<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreIssueRequisition extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'chart_of_account_id', 'product_id','batch_id', 'dn_gp', 'is_approved', 'company_id', 'created_by', 'updated_by', 'is_general', 'is_production'];

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

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function items()
    {
        return $this->hasMany(StoreIssueRequisitionItem::class, 'store_issue_requisition_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'store_issue_requisition_id');
    }
}