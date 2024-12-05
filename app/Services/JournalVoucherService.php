<?php

namespace App\Services;

use App\Models\Company;
use App\Models\JournalVoucher;
use App\Models\JournalVoucherItem;

class JournalVoucherService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $journalVouchers = JournalVoucher::orderBy('created_at', 'asc')->get();
        } else {
            $journalVouchers = JournalVoucher::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $journalVouchers;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['company_id'] = $data['company'];
        
        $company = Company::with('country')->find($data['company_id']);
        if ($company && $company->country) {
            $data['currency'] = $company->country->currency;
        }

        $journalVoucher = JournalVoucher::create($data);

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $journalVoucher->items()->create($value);
        }

        return $journalVoucher;
    }

    public function update(JournalVoucher $journalVoucher, array $data)
    {
        $items = $data['items'] ?? [];

        $data['company_id'] = $data['company'];

        $company = Company::with('country')->find($data['company_id']);
        if ($company && $company->country) {
            $data['currency'] = $company->country->currency;
        }

        $journalVoucher->update($data);
        $journalVoucher->items()->delete();

        foreach ($items as $value) {
            $value['chart_of_account_id'] = $value['chart_of_account'];

            $journalVoucher->items()->create($value);
        }
        
        return $journalVoucher;        
    }

    public function delete(JournalVoucher $journalVoucher)
    {
        return $journalVoucher->delete();
    }

    public function getById($id)
    {
        return JournalVoucher::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastJournalVoucherCode = JournalVoucher::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastJournalVoucherCode) {
            $numberPart = (int) substr($lastJournalVoucherCode, 2);
            $newNumberPart = $numberPart + 1;
            $newJournalVoucherCode = 'JV' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newJournalVoucherCode = 'JV00001';
        }
        return $newJournalVoucherCode;
    }
}