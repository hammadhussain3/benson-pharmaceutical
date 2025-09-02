<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li>
                    <a class="{{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fa fa-cog"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(
                    auth()->user()->hasPermission('Chart Of Accounts List') ||
                    auth()->user()->hasPermission('Credit Note List') ||
                    auth()->user()->hasPermission('Franchise List') ||
                    auth()->user()->hasPermission('Journal Voucher List') ||
                    auth()->user()->hasPermission('Payment Voucher List') ||
                    auth()->user()->hasPermission('Receipt Voucher List') || 
                    auth()->user()->hasPermission('Sale Invoice List') ||
                    auth()->user()->hasPermission('Sales Return List') ||
                    auth()->user()->hasPermission('Sale Warranties List') ||
                    auth()->user()->hasPermission('Supplier List') ||
                    auth()->user()->hasPermission('Tax List')
                )
                    <li class="submenu">
                        <a class="{{ request()->is('chart_of_accounts*') ||
                            request()->is('sub_chart_of_accounts*') ||
                            request()->is('credit-notes*') ||
                            request()->is('franchises*') ||
                            request()->is('journal-vouchers*') ||
                            request()->is('payment-vouchers*') ||
                            request()->is('receipt-vouchers*') ||
                            request()->is('sale-invoices*') ||
                            request()->is('sales-returns*') ||
                            request()->is('sale-warranties*')  ||
                            request()->is('suppliers*') ||
                            request()->is('taxes*') ||
                            request()->is('*amount-sales') ||
                            request()->is('*country-quantity-sales') ||
                            request()->is('*customer-aging') ||
                            request()->is('*franchiser-sales') ||
                            request()->is('*financial-ledger') ? 'active' : '' }}" href="javascript:void(0);">
                            <i class="fa fa-money-bill"></i>
                            <span>Accounts</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            @if(auth()->user()->hasPermission('Chart Of Accounts List'))
                                <li>
                                    <a class="{{ request()->is('chart_of_accounts*') ? 'active' : '' }}" href="{{ route('chart_of_accounts.index') }}">
                                        Chart Of Accounts
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Chart Of Accounts List'))
                                <li>
                                    <a class="{{ request()->is('sub_chart_of_accounts*') ? 'active' : '' }}" href="{{ route('sub_chart_of_accounts.index') }}">
                                        Sub Chart Of Accounts
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Credit Note List'))
                                <li>
                                    <a class="{{ request()->is('credit-notes*') ? 'active' : '' }}" href="{{ route('credit-notes.index') }}">
                                        Credit Notes
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Franchise List'))
                                <li>
                                    <a class="{{ request()->is('franchises*') ? 'active' : '' }}" href="{{ route('franchises.index') }}">
                                        Customers
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Journal Voucher List'))
                                <li>
                                    <a class="{{ request()->is('journal-vouchers*') ? 'active' : '' }}" href="{{ route('journal-vouchers.index') }}">
                                        Journal Vouchers
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Payment Voucher List'))
                                <li>
                                    <a class="{{ request()->is('payment-vouchers*') ? 'active' : '' }}" href="{{ route('payment-vouchers.index') }}">
                                        Payment Vouchers
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Receipt Voucher List'))
                                <li>
                                    <a class="{{ request()->is('receipt-vouchers*') ? 'active' : '' }}" href="{{ route('receipt-vouchers.index') }}">
                                        Receipt Vouchers
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Sale Invoice List'))
                                <li>
                                    <a class="{{ request()->is('sale-invoices*') ? 'active' : '' }}" href="{{ route('sale-invoices.index') }}">
                                        Sale Invoices
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Sales Return List'))
                                <li>
                                    <a class="{{ request()->is('sales-returns*') ? 'active' : '' }}" href="{{ route('sales-returns.index') }}">
                                        Sales Returns
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Sale Warranties List'))
                                <li>
                                    <a class="{{ request()->is('sale-warranties*') ? 'active' : '' }}" href="{{ route('sale-warranties.index') }}">
                                        Sale Warranties
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Supplier List'))
                                <li>
                                    <a class="{{ request()->is('suppliers*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                        Supplier
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Tax List'))
                                <li>
                                    <a class="{{ request()->is('taxes*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
                                        Taxes
                                    </a>
                                </li>
                            @endif
                            <li class="mx-3">
                                <div class="position-relative mx-1">
                                    <hr class="border border-1">
                                    <div class="position-absolute top-0 start-0 translate-middle-y badge bg-secondary">Reports</div>
                                </div>
                            </li>
                            <li>
                                <a class="{{ request()->is('*amount-sales') ? 'active' : '' }}" href="{{ route('reports.country-amount-sales') }}">
                                    Country Sales Report Amount Wise
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('*country-quantity-sales') ? 'active' : '' }}" href="{{ route('reports.country-quantity-sales') }}">
                                    Country Sales Report Quantity Wise
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('*customer-aging') ? 'active' : '' }}" href="{{ route('reports.customer-aging') }}">
                                    Customer Aging Report
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('*franchiser-sales') ? 'active' : '' }}" href="{{ route('reports.franchiser-sales') }}">
                                    Distributor Sales Report
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('*financial-ledger') ? 'active' : '' }}" href="{{ route('reports.financial-ledger') }}">
                                    Financial Ledger Report
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Bank List') ||
                    auth()->user()->hasPermission('Branches List') ||
                    auth()->user()->hasPermission('Cities List') ||
                    auth()->user()->hasPermission('Companies List') ||
                    auth()->user()->hasPermission('Countries List') ||
                    auth()->user()->hasPermission('Departments List') ||
                    auth()->user()->hasPermission('Roles List') ||
                    auth()->user()->hasPermission('Users List')
                )
                    <li class="submenu">
                        <a class="{{ request()->is('banks*') ||
                            request()->is('branches*') ||
                            request()->is('cities*') ||
                            request()->is('companies*') ||
                            request()->is('countries*') ||
                            request()->is('departments*') ||
                            request()->is('roles*') ||
                            request()->is('users*') ? 'active' : '' }}" href="javascript:void(0);">
                            <i class="fa fa-user-tie"></i>
                            <span>Admin</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            @if(auth()->user()->hasPermission('Bank List'))
                                <li>
                                    <a class="{{ request()->is('banks*') ? 'active' : '' }}" href="{{ route('banks.index') }}">
                                        Banks
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Branches List'))
                                <li>
                                    <a class="{{ request()->is('branches*') ? 'active' : '' }}" href="{{ route('branches.index') }}">
                                        Branches
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Cities List'))
                                <li>
                                    <a class="{{ request()->is('cities*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
                                        Cities
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Companies List'))
                                <li>
                                    <a class="{{ request()->is('companies*') ? 'active' : '' }}" href="{{ route('companies.index') }}">
                                        Companies
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Countries List'))
                                <li>
                                    <a class="{{ request()->is('countries*') ? 'active' : '' }}" href="{{ route('countries.index') }}">
                                        Countries
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Departments List'))
                                <li>
                                    <a class="{{ request()->is('departments*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                        Departments
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Roles List'))
                                <li>
                                    <a class="{{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                        Roles
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Users List'))
                                <li>
                                    <a class="{{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        Users
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Designation List') ||
                    auth()->user()->hasPermission('Employee List') ||
                    auth()->user()->hasPermission('Leave List') ||
                    auth()->user()->hasPermission('Leave Type List') ||
                    auth()->user()->hasPermission('Loan List') ||
                    auth()->user()->hasPermission('Salaries List') ||
                    auth()->user()->hasPermission('Salary Tax Slabs List')
                )
                    <li class="submenu">
                        <a class="{{ request()->is('designations*') ||
                            request()->is('employees*') ||
                            request()->is('leaves*') ||
                            request()->is('leave_types*') ||
                            request()->is('loans*') ||
                            request()->is('salary_slips*') ||
                            request()->is('tax-slabs*') ? 'active' : '' }}" href="javascript:void(0);">
                            <i class="fa fa-users"></i>
                            <span>Human Resource</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            @if(auth()->user()->hasPermission('Employee List'))
                                <li>
                                    <a class="{{ request()->is('employees*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                                        Employees
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Leave List'))
                                <li>
                                    <a class="{{ request()->is('leaves*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                                        Leave
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Loan List'))
                                <li>
                                    <a class="{{ request()->is('loans*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                                        Loan
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Salaries List'))
                                <li>
                                    <a class="{{ request()->is('salary_slips*') ? 'active' : '' }}" href="{{ route('salary_slips.index') }}">
                                        Salaries
                                    </a>
                                </li>
                            @endif
                            <li class="mx-3">
                                <div class="position-relative mx-1">
                                    <hr class="border border-1">
                                    <div class="position-absolute top-0 start-0 translate-middle-y badge bg-secondary">Config</div>
                                </div>
                            </li>
                            @if(auth()->user()->hasPermission('Designation List'))
                                <li>
                                    <a class="{{ request()->is('designations*') ? 'active' : '' }}" href="{{ route('designations.index') }}">
                                        Designations
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Employee List'))
                                <li>
                                    <a class="{{ request()->is('employee-types*') ? 'active' : '' }}" href="{{ route('employee-types.index') }}">
                                        Employee Types
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Leave Type List'))
                                <li>
                                    <a class="{{ request()->is('leave_types*') ? 'active' : '' }}" href="{{ route('leave_types.index') }}">
                                        Leave Type
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Salary Tax Slabs List'))
                                <li>
                                    <a class="{{ request()->is('tax-slabs*') ? 'active' : '' }}" href="{{ route('tax-slabs.index') }}">
                                        Salary Tax Slabs
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Purchase Requisition List') || // change to Manual Purchase Requisitions
                    auth()->user()->hasPermission('Payment Types List') ||
                    auth()->user()->hasPermission('Purchase Invoice List') // change to Purchase Requisitions
                )
                <li class="submenu">
                    <a class="{{ request()->is('purchase-requisitions*') || // change to Manual Purchase Requisitions
                        request()->is('payment_types*') ||
                        request()->is('invoices*') || // change to Purchase Requisitions
                        request()->is('*purchase-items') ||
                        request()->is('*purchase-order-appraisal') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-truck"></i>
                        <span>Procurement</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('Purchase Requisition List'))
                            <li>
                                <a class="{{ request()->is('purchase-requisitions*') ? 'active' : '' }}" href="{{ route('purchase-requisitions.index') }}">
                                    Manual Purchase Requisitions
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Payment Types List'))
                            <li>
                                <a class="{{ request()->is('payment_types*') ? 'active' : '' }}" href="{{ route('payment_types.index') }}">
                                    Payment Types
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Purchase Invoice List'))
                            <li>
                                <a class="{{ request()->is('purchase-invoices*') ? 'active' : '' }}" href="{{ route('purchase-invoices.index') }}">
                                    Purchase Order
                                </a>
                            </li>
                        @endif
                        <li class="mx-3">
                            <div class="position-relative mx-1">
                                <hr class="border border-1">
                                <div class="position-absolute top-0 start-0 translate-middle-y badge bg-secondary">Reports</div>
                            </div>
                        </li>
                        <li>
                            <a class="{{ request()->is('*purchase-items') ? 'active' : '' }}" href="{{ route('reports.purchase-items') }}">
                                Purchase Order
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*purchase-order-appraisal') ? 'active' : '' }}" href="{{ route('reports.purchase-order-appraisal') }}">
                                Purchase Order Appraisal
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Batch List') ||
                    auth()->user()->hasPermission('Product List') || // Change to Brand
                    auth()->user()->hasPermission('Category List') ||
                    auth()->user()->hasPermission('Dosage Form List') ||
                    auth()->user()->hasPermission('Finished Goods Receiving List') ||
                    auth()->user()->hasPermission('Goods Receiving List') ||
                    auth()->user()->hasPermission('Left Over Note List') ||
                    auth()->user()->hasPermission('PackForm List') ||
                    auth()->user()->hasPermission('PackSize List') ||
                    auth()->user()->hasPermission('PackingType List') ||
                    auth()->user()->hasPermission('Product Variation List')  || // Change to Product
                    auth()->user()->hasPermission('ProductGroup List') ||
                    auth()->user()->hasPermission('Raw Material Item List')|| 
                    auth()->user()->hasPermission('Rejection Return Note List') ||
                    auth()->user()->hasPermission('Stock List') ||
                    auth()->user()->hasPermission('Store Issue Rquisition List') ||
                    auth()->user()->hasPermission('Sub Category List')
                )
                <li class="submenu">
                    <a class="{{ request()->is('batches*') ||
                        request()->is('products*') || // Change to Brand
                        request()->is('categories*') ||
                        request()->is('dosage-forms*') ||
                        request()->is('finished-goods-receivings*') ||
                        request()->is('goods-receivings*') ||
                        request()->is('left-over-notes*') ||
                        request()->is('master-formulations*') ||
                        request()->is('pack-forms*') ||
                        request()->is('pack_size*') ||
                        request()->is('packingtypes*') ||
                        request()->is('product-variations*') || // Change to Product
                        request()->is('product-groups*') ||
                        request()->is('raw-material-items*') ||
                        request()->is('rejection-return-notes*') ||
                        request()->is('stocks*') ||
                        request()->is('store-issue-requisitions*') ||
                        request()->is('sub-categories*') ||
                        request()->is('*current-balance-report') ||
                        request()->is('*batch-balance') ||
                        request()->is('*batch-report') ||
                        request()->is('*consumption-report') ||
                        request()->is('*production-report')  ||
                        request()->is('*requirement-report') ||
                        request()->is('*stock-bin-card') ? 'active' : ''}}" href="javascript:void(0);">
                        <i class="fa fa-store"></i>
                        <span>Store</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('Batch List'))
                            <li>
                                <a class="{{ request()->is('batches*') ? 'active' : '' }}" href="{{ route('batches.index') }}">
                                    Batches
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Product List'))
                            <li>
                                <a class="{{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    Brands
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Category List'))
                            <li>
                                <a class="{{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    Categories
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Dosage Form List'))
                            <li>
                                <a class="{{ request()->is('dosage-forms*') ? 'active' : '' }}" href="{{ route('dosage-forms.index') }}">
                                    Dosage Form
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Finished Goods Receiving List'))
                            <li>
                                <a class="{{ request()->is('finished-goods-receiving*') ? 'active' : '' }}" href="{{ route('finished-goods-receivings.index') }}">
                                   Finished Goods Receiving Notes
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Goods Receiving List'))
                            <li>
                                <a class="{{ request()->is('goods-receivings*') ? 'active' : '' }}" href="{{ route('goods-receivings.index') }}">
                                    Goods Receiving Notes
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Left Over Note List'))
                            <li>
                                <a class="{{ request()->is('left-over-notes*') ? 'active' : '' }}" href="{{ route('left-over-notes.index') }}">
                                    Left Over Note
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="{{ request()->is('master-formulations*') ? 'active' : '' }}" href="{{ route('master-formulations.index') }}">
                                Master Formulations
                            </a>
                        </li>
                        @if(auth()->user()->hasPermission('PackForm List'))
                            <li>
                                <a class="{{ request()->is('pack-forms*') ? 'active' : '' }}" href="{{ route('pack-forms.index') }}">
                                    Pack Forms
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('PackSize List'))
                            <li>
                                <a class="{{ request()->is('pack_size*') ? 'active' : '' }}" href="{{ route('pack_size.index') }}">
                                    Pack Size
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('PackingType List'))
                            <li>
                                <a class="{{ request()->is('packingtypes*') ? 'active' : '' }}" href="{{ route('packingtypes.index') }}">
                                    Packing Types
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Product Variation List'))
                            <li>
                                <a class="{{ request()->is('product-variations*') ? 'active' : '' }}" href="{{ route('product-variations.index') }}">
                                    Products
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('ProductGroup List'))
                            <li>
                                <a class="{{ request()->is('product-groups*') ? 'active' : '' }}" href="{{ route('product-groups.index') }}">
                                    Product Groups
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Raw Material Item List'))
                            <li>
                                <a class="{{ request()->is('raw-material-items*') ? 'active' : '' }}" href="{{ route('raw-material-items.index') }}">
                                    Raw Material Items
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Rejection Return Note List'))
                            <li>
                                <a class="{{ request()->is('rejection-return-notes*') ? 'active' : '' }}" href="{{ route('rejection-return-notes.index') }}">
                                    Rejection Return Note
                                </a>
                            </li>
                        @endif
                        {{-- @if(auth()->user()->hasPermission('Stock List'))
                            <li>
                                <a class="{{ request()->is('stocks*') ? 'active' : '' }}" href="{{ route('stocks.index') }}">
                                    Stocks
                                </a>
                            </li>
                        @endif --}}
                        @if(auth()->user()->hasPermission('Store Issue Rquisition List'))
                            <li>
                                <a class="{{ request()->is('store-issue-requisitions*') ? 'active' : '' }}" href="{{ route('store-issue-requisitions.index') }}">
                                    Store Issue Rquisitions
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Sub Category List'))
                            <li>
                                <a class="{{ request()->is('sub-categories*') ? 'active' : '' }}" href="{{ route('sub-categories.index') }}">
                                    Sub Categories
                                </a>
                            </li>
                        @endif
                        <li class="mx-3">
                            <div class="position-relative mx-1">
                                <hr class="border border-1">
                                <div class="position-absolute top-0 start-0 translate-middle-y badge bg-secondary">Reports</div>
                            </div>
                        </li>
                        <li>
                            <a class="{{ request()->is('*current-balance-report') ? 'active' : '' }}" href="{{ route('reports.current-balance-report') }}">
                                Current Balance Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*batch-balance') ? 'active' : '' }}" href="{{ route('reports.batch-balance-report') }}">
                                Batch Balance Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*batch-report') ? 'active' : '' }}" href="{{ route('reports.batch-report') }}">
                                Batch Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*consumption-report') ? 'active' : '' }}" href="{{ route('reports.consumption-report') }}">
                                Consumption Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*production-report') ? 'active' : '' }}" href="{{ route('reports.production-report') }}">
                                Production Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*requirement-report') ? 'active' : '' }}" href="{{ route('reports.requirement-report') }}">
                                Requirement Report
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->is('*stock-bin-card') ? 'active' : '' }}" href="{{ route('reports.stock-bin-card') }}">
                                Stock Bin Card
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>