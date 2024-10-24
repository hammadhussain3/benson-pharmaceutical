<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryTaxSlab extends Model
{
    use HasFactory;

    protected $fillable = [
        'slab_start',
        'slab_end',
        'tax_value',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
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
}
