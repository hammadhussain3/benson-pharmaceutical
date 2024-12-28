@extends('admin.layouts.app')
@section('content')
    @php
        $companyId = !auth()->user()->hasRole('Superadmin') ? auth()->user()->employee->compnay_id : null;
        $totalPurchaseDueAmount = $companyId 
            ? App\Models\Invoice::where('type', 'purchase')->where('company_id', $companyId)->sum('due_amount') 
            : App\Models\Invoice::where('type', 'purchase')->sum('due_amount');
        $totalSaleDueAmount = $companyId 
            ? App\Models\Invoice::where('type', 'sale')->where('company_id', $companyId)->sum('due_amount') 
            : App\Models\Invoice::where('type', 'sale')->sum('due_amount');
        $totalPurchaseAmount = $companyId 
            ? App\Models\Invoice::where('type', 'purchase')->where('company_id', $companyId)->sum('total_amount') 
            : App\Models\Invoice::where('type', 'purchase')->sum('total_amount');
        $totalSaleAmount = $companyId 
            ? App\Models\Invoice::where('type', 'sale')->where('company_id', $companyId)->sum('total_amount') 
            : App\Models\Invoice::where('type', 'sale')->sum('total_amount');
        $customers = $companyId 
            ? App\Models\Party::where('is_distributor', '1')->where('company_id', $companyId)->count() 
            : App\Models\Party::where('is_distributor', '1')->count();
        $suppliers = $companyId 
            ? App\Models\Party::where('is_supplier', '1')->where('company_id', $companyId)->count() 
            : App\Models\Party::where('is_supplier', '1')->count();
        $purchaseInvoices = $companyId 
            ? App\Models\Invoice::where('type', 'purchase')->where('company_id', $companyId)->count() 
            : App\Models\Invoice::where('type', 'purchase')->count();
        $saleInvoices = $companyId 
            ? App\Models\Invoice::where('type', 'sale')->where('company_id', $companyId)->count() 
            : App\Models\Invoice::where('type', 'sale')->count();
    @endphp

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalPurchaseDueAmount }}">${{ $totalPurchaseDueAmount }}</span></h5>
                    <h6>Total Purchase Due</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash1">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalSaleDueAmount }}">${{ $totalSaleDueAmount }}</span></h5>
                    <h6>Total Sales Due</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash2">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalPurchaseAmount }}">{{ $totalPurchaseAmount }}</span></h5>
                    <h6>Total Purchase Amount</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalSaleAmount }}">{{ $totalSaleAmount }}</span></h5>
                    <h6>Total Sale Amount</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{ $customers }}</h4>
                    <h5>Customers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{ $suppliers }}</h4>
                    <h5>Suppliers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>{{ $purchaseInvoices }}</h4>
                    <h5>Purchase Invoice</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file-text"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-counts">
                    <h4>{{ $saleInvoices }}</h4>
                    <h5>Sales Invoice</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
