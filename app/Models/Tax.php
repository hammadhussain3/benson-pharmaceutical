<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate', 'company_id', 'created_by', 'updated_by'];

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
    
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
