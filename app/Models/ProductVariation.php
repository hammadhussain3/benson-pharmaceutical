<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'reg_no', 'product_id', 'dosage_form_id', 'pack_form_id', 'packing_type_id', 'pack_size_id', 'product_group_id', 'category_id', 'trade_price', 'our_mrp', 'drap_mrp', 'min_level', 'max_level', 'company_id', 'created_by', 'updated_by'];

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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosageForm()
    {
        return $this->belongsTo(DosageForm::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packForm()
    {
        return $this->belongsTo(PackForm::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packSize()
    {
        return $this->belongsTo(PackSize::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packingType()
    {
        return $this->belongsTo(PackingType::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id', 'id');
    }

    public function finishedProducts()
    {
        return $this->hasMany(FinishedGoodsReceivingItem::class);
    }

    public function balance()
    {
        $balanceData = Stock::currentBalanceForItem(null, null, $this->id);
        return $balanceData['balance'];
    }
}
