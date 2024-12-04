<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptVoucherItem extends Model
{
    use HasFactory;

    protected $fillable = ['receipt_voucher_id', 'chart_of_account_id', 'description', 'debit', 'credit'];

    public function receiptVoucher()
    {
        return $this->belongsTo(ReceiptVoucher::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
