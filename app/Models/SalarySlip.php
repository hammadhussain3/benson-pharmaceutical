<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leaves',
        'late_in_early_out_deduction',
        'overtime',
        'arrears',
        'income_tax',
        'loan_advance',
        'payment_mode',
        'month',
        'year',
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
