<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalVoucherItem extends Model
{
    use HasFactory;

    protected $fillable = ['journal_voucher_id', 'chart_of_account_id', 'description', 'debit', 'credit'];

    public function journalVoucher()
    {
        return $this->belongsTo(JournalVoucher::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
