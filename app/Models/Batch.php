<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Batch
 *
 * @property $id
 * @property $batchno
 * @property $batch_size
 * @property $product_id
 * @property $mfg_date
 * @property $exp_date
 * @property $status
 * @property $created_by
 * @property $updated_by
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Batch extends Model
{
    use HasFactory;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['batchno', 'batch_size', 'product_id', 'mfg_date', 'exp_date', 'status', 'created_by', 'updated_by'];

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

    // Define the relationship to Products
    public function product()
    {
        return $this->belongsTo(Product::class);
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
