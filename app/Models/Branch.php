<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'address',
        'country_id',
        'city_id',
        'phone',
        'email',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'is_active',
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
    // Relationship with the Company model
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with the Country model
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relationship with the City model
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
