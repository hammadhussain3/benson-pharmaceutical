<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function currentBalanceReport()
    {
       $stocks = Stock::with('product')->get();
       return view('admin.reports.current_balance_report',compact('stocks'));
    }
}
