@extends('admin.layouts.app')
@section('content')
    @php
        use Carbon\Carbon;

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
        $totalUsers = \DB::table('users')->count();
        $totalCompanies = \DB::table('companies')->count();
        $totalBranches = \DB::table('branches')->count();
        $user_id = auth()->id();
        $company_Id = App\Models\Employee::where('id', $user_id)->count();
        $totalInvoices = \DB::table('invoices')->where('company_id', $company_Id)->count();
        $totalSuppliers = \DB::table('parties')->where('company_id', $company_Id)->where('is_supplier', 1)->count();
        $totalFranchisers = \DB::table('parties')
            ->where('company_id', $company_Id)
            ->where('is_distributor', 1)
            ->count();
        $store_issue_requisitions = \DB::table('store_issue_requisitions')->where('company_id', $company_Id)->count();
        $raw_material_items = \DB::table('raw_material_items')->where('company_id', $company_Id)->count();
        $totalCompaniesThisMonth = \DB::table('companies')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $totalBranchesThisMonth = \DB::table('branches')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $totalproductsThisMonth = \DB::table('products')
            ->where('company_id', $company_Id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $totalInvoicesThisMonth = \DB::table('invoices')
            ->where('company_id', $company_Id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    @endphp


    <div class="row">
        @role('Superadmin')
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/company.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters"></span>{{ $totalCompanies }}</h5>
                        <h6>Total companies</h6>
                    </div>
                    {{-- <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalPurchaseDueAmount }}">${{ $totalPurchaseDueAmount }}</span></h5>
                    <h6>Total Purchase Due</h6>
                </div> --}}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/branch.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalBranches }}</span></h5>
                        <h6>Total branches<br></h6>
                    </div>
                    {{-- <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="{{ $totalSaleDueAmount }}">${{ $totalSaleDueAmount }}</span></h5>
                    <h6>Total Sales Due</h6>
                </div> --}}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/company.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalBranchesThisMonth }}</span>
                        </h5>
                        <h6>Total companies - This month</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/branch.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalCompaniesThisMonth }}</span>
                        </h5>
                        <h6>Total branches - This month</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/users.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalUsers }}</span>
                        </h5>
                        <h6>Total users</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
            </div>
        @endrole
        @role('Admin')
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/company.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $raw_material_items }}</span>
                        </h5>
                        <h6>Total raw materials</h6>
                        <br>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/supplier.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalSuppliers }}</span></h5>
                        <h6>Total suppliers</h6>
                        <br>

                    </div>
                    {{-- <div class="dash-widgetcontent">
                <h5>$<span class="counters" data-count="{{ $totalSaleDueAmount }}">${{ $totalSaleDueAmount }}</span></h5>
                <h6>Total Sales Due</h6>
            </div> --}}
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/franchiser.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalFranchisers }}</span>
                        </h5>
                        <h6>Total Franchisers</h6>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/sir.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters"></span>{{ $totalInvoicesThisMonth }}</h5>
                        <h6>Total Invoices - This Month</h6>


                    </div>
                    {{-- <div class="dash-widgetcontent">
                <h5>$<span class="counters" data-count="{{ $totalPurchaseDueAmount }}">${{ $totalPurchaseDueAmount }}</span></h5>
                <h6>Total Purchase Due</h6>
            </div> --}}
                </div>
            </div>
        @endrole
        @role('Manager')
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/invoice.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters"></span>{{ $totalInvoices }}</h5>
                        <h6>Total Invoices</h6>
                        <br>

                    </div>
                    {{-- <div class="dash-widgetcontent">
                <h5>$<span class="counters" data-count="{{ $totalPurchaseDueAmount }}">${{ $totalPurchaseDueAmount }}</span></h5>
                <h6>Total Purchase Due</h6>
            </div> --}}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/sir.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $store_issue_requisitions }}</span></h5>
                        <h6>Total SIR</h6>
                        <br>

                    </div>
                    {{-- <div class="dash-widgetcontent">
                <h5>$<span class="counters" data-count="{{ $totalSaleDueAmount }}">${{ $totalSaleDueAmount }}</span></h5>
                <h6>Total Sales Due</h6>
            </div> --}}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/company.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $raw_material_items }}</span>
                        </h5>
                        <h6>Total raw materials</h6>
                        <br>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/product.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $totalproductsThisMonth }}</span>
                        </h5>
                        <h6>Total products - This month</h6>
                    </div>
                </div>
            </div>
        @endrole

        {{-- @role('Superadmin')
        @else

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
            @endrole --}}
    </div>
@endsection
