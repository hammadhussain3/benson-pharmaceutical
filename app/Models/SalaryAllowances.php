<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllowances extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_slip_id',
        'employee_id',
        'name',
        'amount',
        'type',
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
}
