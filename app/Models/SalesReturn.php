<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'party_id', 'inclusive_tax', 'tax_rate', 'total_tax', 'exclusive_tax', 'discount_type', 'discount', 'total_amount', 'is_approved', 'company_id', 'created_by', 'updated_by'];

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

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function items()
    {
        return $this->hasMany(SalesReturnItem::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'sales_return_id');
    }
}
