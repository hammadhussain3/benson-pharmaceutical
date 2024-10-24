<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'country_id',
        'city_id',
        'phone',
        'email',
        'website',
        'ntn',
        'strn',
        'is_active',
        'logo_path',
        'created_by',
        'updated_by'
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
    // Define the relationship with the City model
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // Define the relationship with the Country model
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
