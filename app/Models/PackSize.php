<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_id',
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

    // Define the relationship to Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Define the relationship to User (Created By)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Define the relationship to User (Updated By)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
