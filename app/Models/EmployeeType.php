<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'description', 'company_id', 'created_by', 'updated_by'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employees()
    {
        return $this->hasMany(EmployeeType::class);
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
