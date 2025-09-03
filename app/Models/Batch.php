<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['batch_no', 'batch_size', 'product_id', 'master_formulation_id', 'mfg_date', 'exp_date', 'start_date', 'end_date', 'chart_of_account_id', 'sub_chart_of_account_id', 'status', 'company_id', 'created_by', 'updated_by'];

    protected $casts = [
        'mfg_date' => 'date',
        'exp_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    // Define the relationship to Products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function masterFormulation()
    {
        return $this->belongsTo(MasterFormulation::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(BatchProduct::class, 'batch_id');
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function sub_chart_of_account()
    {
        return $this->belongsTo(SubChartOfAccount::class);
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

    /**
     * Safely format a date field
     */
    public function formatDate($field, $format = 'd/m/Y')
    {
        $date = $this->getAttribute($field);
        if (!$date) {
            return 'N/A';
        }
        
        if (is_string($date)) {
            return $date;
        }
        
        return $date->format($format);
    }
}
