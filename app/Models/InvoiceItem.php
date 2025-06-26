<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 
        'product_variation_id', 
        'raw_material_item_id', 
        'product_group_id', 
        'batch_id', 
        'code',
        'title',
        'description',
        'balance',
        'min_level',
        'max_level',
        'lp_ref',
        'lp_price',
        'ip_po_list',
        'ip_quantity',
        'consumption_6_month',
        'unit', 
        'unit_price', 
        'quantity', 
        'tax_rate', 
        'discount_type', 
        'discount',
        'total_amount'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->product_variation_id) {
                $productVariation = ProductVariation::find($model->product_variation_id);
                if ($productVariation && $productVariation->product) {
                    $model->product_group_id = $productVariation->product->product_group_id;
                }
            }
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function rawMaterialItem()
    {
        return $this->belongsTo(RawMaterialItem::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function getItemAttribute()
    {
        return $this->product_id
            ? $this->product
            : $this->rawMaterialItem;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function getLastPurchaseByRawMaterial($rawMaterialItemId, $invoiceItemId = null)
    {
        $query = self::with(['invoice.party'])
            ->whereHas('invoice', fn($q) => $q->where('type', 'purchase'))
            ->where('raw_material_item_id', $rawMaterialItemId);

        if ($invoiceItemId) {
            $query->where('id', '<', $invoiceItemId);
        }

        $record = $query->orderByDesc('invoice_id')->first();

        if ($record) {
            return [
                'invoice_id'            => $record->invoice_id,
                'supplier_id'           => $record->invoice->party_id ?? null,
                'raw_material_item_id'  => $record->raw_material_item_id,
                'invoice_code'          => $record->invoice->code ?? null,
                'price'                 => $record->unit_price,
                'unit'                  => $record->unit,
                'supplier_name'         => $record->invoice->party->name ?? null,
                'supplier_code'         => $record->invoice->party->code ?? null,
            ];
        }

        return null;
    }
}