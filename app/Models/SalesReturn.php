<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'party_id', 'inclusive_tax', 'tax_rate', 'total_tax', 'exclusive_tax', 'discount_type', 'discount', 'total_amount', 'company_id', 'created_by', 'updated_by'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function items()
    {
        return $this->hasMany(SalesReturnItem::class);
    }
    
}
