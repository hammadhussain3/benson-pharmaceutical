<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'prefix',
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
