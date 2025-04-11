<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalVoucher extends Model
{
    use HasFactory;
    
    protected $perPage = 20;

    protected $fillable = ['code', 'year', 'total_debit', 'total_credit', 'currency', 'is_approved', 'company_id', 'created_by', 'updated_by'];

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

    public function items()
    {
        return $this->hasMany(JournalVoucherItem::class);
    }
}