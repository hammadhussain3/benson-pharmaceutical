<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'basic_pay',
        'allowances',
        'date_of_joining',
        'designation_id',
        'department_id',
        'bank_id',
        'bank_account',
        'is_active',
        'branch_id',
        'company_id',
        'employee_type_id',
        'created_by',
        'updated_by'
    ];

    // Relationships
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employee_type()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function leaves() // Add this method
    {
        return $this->hasMany(Leave::class);
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
