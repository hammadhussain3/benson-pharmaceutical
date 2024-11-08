<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['reg_no', 'name', 'generic_name', 'brand_name', 'therapeutic_class', 'code', 'product_group_id', 'company_id', 'created_by', 'updated_by'];

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
        return $this->belongsTo(\App\Models\Company::class, 'company_id', 'id');
    }
    
    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id', 'id');
    }
    
}
