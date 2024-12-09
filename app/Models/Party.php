<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'phone',
        'email',
        'country_id',
        'city_id',
        'address',
        'payment_type_id',
        'is_supplier',
        'is_distributor',
        'company_id',
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
    // Relationships can be defined here
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNote::class);
    }

    public function paymentReceipts()
    {
        return $this->hasMany(ReceiptVoucher::class);
    }

    public function getCurrentBalanceAttribute()
    {
        // Total debit: invoices and credit notes
        $totalDebit = $this->invoices()->sum('total_amount') 
            + $this->creditNotes()->sum('total');

        // Total credit: payment receipts
        $totalCredit = $this->paymentReceipts()->sum('total');

        return $totalDebit - $totalCredit;
    }

    public function getBalanceBeforeDate($date)
    {
        // Total debit: invoices and credit notes before the given date
        $totalDebit = $this->invoices()
            ->where('created_at', '<', $date)
            ->sum('total_amount')
            + $this->creditNotes()
            ->where('created_at', '<', $date)
            ->sum('total');

        // Total credit: payment receipts before the given date
        $totalCredit = $this->paymentReceipts()
            ->where('created_at', '<', $date)
            ->sum('total');

        return $totalDebit - $totalCredit;
    }
}
