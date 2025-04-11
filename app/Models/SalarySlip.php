<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'income',
        'leaves',
        'late_in_early_out_deduction',
        'eob',
        'overtime',
        'arrears',
        'income_tax',
        'loan_advance',
        'payment_mode',
        'month',
        'year',
        'is_approved',
        'company_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'leaves' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function allowances()
    {
        return $this->hasMany(SalaryAllowances::class);
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