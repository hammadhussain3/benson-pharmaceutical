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
                            <span>Admin</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            @if(auth()->user()->hasPermission('Bank List'))
                                <li>
                                    <a class="{{ request()->is('banks*') ? 'active' : '' }}" href="{{ route('banks.index') }}">
                                        <i class="fa fa-building me-1"></i>
                                        Banks
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Branches List'))
                                <li>
                                    <a class="{{ request()->is('branches*') ? 'active' : '' }}" href="{{ route('branches.index') }}">
                                        <i class="fa fa-code-branch me-1"></i>
                                        Branches
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Cities List'))
                                <li>
                                    <a class="{{ request()->is('cities*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
                                        <i class="fa fa-city me-1"></i>
                                        Cities
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Companies List'))
                                <li>
                                    <a class="{{ request()->is('companies*') ? 'active' : '' }}" href="{{ route('companies.index') }}">
                                        <i class="fa fa-building me-1"></i>
                                        Companies
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Countries List'))
                                <li>
                                    <a class="{{ request()->is('countries*') ? 'active' : '' }}" href="{{ route('countries.index') }}">
                                        <i class="fa fa-globe me-1"></i>
                                        Countries
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Departments List'))
                                <li>
                                    <a class="{{ request()->is('departments*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                        <i class="fa fa-sitemap me-1"></i>
                                        Departments
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Roles List'))
                                <li>
                                    <a class="{{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                        <i class="fa fa-lock me-1"></i>
                                        Roles
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Users List'))
                                <li>
                                    <a class="{{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="fa fa-user me-1"></i>
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
                            <span>Human Resource</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            @if(auth()->user()->hasPermission('Designation List'))
                                <li>
                                    <a class="{{ request()->is('designations*') ? 'active' : '' }}" href="{{ route('designations.index') }}">
                                        <i class="fa fa-briefcase me-1"></i>
                                        Designations
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Employee List'))
                                <li>
                                    <a class="{{ request()->is('employees*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                                        <i class="fa fa-users me-1"></i>
                                        Employees
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Leave List'))
                                <li>
                                    <a class="{{ request()->is('leaves*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                                        <i class="fa fa-calendar me-1"></i>
                                        Leave
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Leave Type List'))
                                <li>
                                    <a class="{{ request()->is('leave_types*') ? 'active' : '' }}" href="{{ route('leave_types.index') }}">
                                        <i class="fa fa-tags me-1"></i>
                                        Leave Type
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Loan List'))
                                <li>
                                    <a class="{{ request()->is('loans*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                                        <i class="fa fa-handshake me-1"></i>
                                        Loan
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Salaries List'))
                                <li>
                                    <a class="{{ request()->is('salary_slips*') ? 'active' : '' }}" href="{{ route('salary_slips.index') }}">
                                        <i class="fa fa-calculator me-1"></i>
                                        Salaries
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission('Salary Tax Slabs List'))
                                <li>
                                    <a class="{{ request()->is('tax-slabs*') ? 'active' : '' }}" href="{{ route('tax-slabs.index') }}">
                                        <i class="fa fa-percent me-1"></i>
                                        Salary Tax Slabs
                                    </a>
                                </li>
                            @endif
                            {{-- <li>
                                <a class="{{ request()->is('salary-sheet*') ? 'active' : '' }}" href="{{ route('salary.sheet.index') }}">Salary Sheet</a>
                            </li> --}}
                        </ul>
                    </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Batch List') ||
                    auth()->user()->hasPermission('Category List') ||
                    auth()->user()->hasPermission('Chart Of Accounts List') ||
                    auth()->user()->hasPermission('Dosage Form List') ||
                    auth()->user()->hasPermission('Franchise List') ||
                    auth()->user()->hasPermission('Invoice List') ||
                    auth()->user()->hasPermission('PackForm List') ||
                    auth()->user()->hasPermission('PackingType List') ||
                    auth()->user()->hasPermission('PackSize List') ||
                    auth()->user()->hasPermission('Payment Types List') ||
                    auth()->user()->hasPermission('Product List') ||
                    auth()->user()->hasPermission('ProductGroup List') ||
                    auth()->user()->hasPermission('Product Variation List') ||
                    auth()->user()->hasPermission('Purchase Requisition List') ||
                    auth()->user()->hasPermission('Raw Material Item List') ||
                    auth()->user()->hasPermission('Supplier List') ||
                    auth()->user()->hasPermission('Tax List')
                )
                <li class="submenu">
                    <a class="{{ request()->is('batches*') ||
                    request()->is('categories*') ||
                    request()->is('chart_of_accounts*') ||
                    request()->is('dosage-forms*') ||
                    request()->is('franchises*') ||
                    request()->is('invoices*') ||
                    request()->is('pack-forms*') ||
                    request()->is('pack_size*') ||
                    request()->is('packingtypes*') ||
                    request()->is('payment_types*') ||
                    request()->is('products*') ||
                    request()->is('product-groups*') ||
                    request()->is('product-variations*') ||
                    request()->is('purchase-requisitions*') ||
                    request()->is('raw-material-items*') ||
                    request()->is('suppliers*') ||
                    request()->is('taxes*') ? 'active' : '' }}" href="javascript:void(0);">
                        <span>Procurement</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('Batch List'))
                            <li>
                                <a class="{{ request()->is('batches*') ? 'active' : '' }}" href="{{ route('batches.index') }}">
                                    <i class="fa fa-layer-group me-1"></i>
                                    Batches
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Category List'))
                            <li>
                                <a class="{{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="fa fa-layer-group me-1"></i>
                                    Categories
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Chart Of Accounts List'))
                            <li>
                                <a class="{{ request()->is('chart_of_accounts*') ? 'active' : '' }}" href="{{ route('chart_of_accounts.index') }}">
                                    <i class="fa fa-list-alt"></i>
                                    Chart Of Accounts
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Dosage Form List'))
                            <li>
                                <a class="{{ request()->is('dosage-forms*') ? 'active' : '' }}" href="{{ route('dosage-forms.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Dosage Form
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Franchise List'))
                            <li>
                                <a class="{{ request()->is('franchises*') ? 'active' : '' }}" href="{{ route('franchises.index') }}">
                                    <i class="fa fa-truck me-1"></i>Franchises
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Invoice List'))
                            <li>
                                <a class="{{ request()->is('invoices*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Invoices
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('PackForm List'))
                            <li>
                                <a class="{{ request()->is('pack-forms*') ? 'active' : '' }}" href="{{ route('pack-forms.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Pack Forms
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('PackingType List'))
                            <li>
                                <a class="{{ request()->is('packingtypes*') ? 'active' : '' }}" href="{{ route('packingtypes.index') }}">
                                    <i class="fa fa-box me-1"></i>
                                    Packing Types
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('PackSize List'))
                            <li>
                                <a class="{{ request()->is('pack_size*') ? 'active' : '' }}" href="{{ route('pack_size.index') }}">
                                    <i class="fa fa-boxes me-1"></i>
                                    Pack Size
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Payment Types List'))
                            <li>
                                <a class="{{ request()->is('payment_types*') ? 'active' : '' }}" href="{{ route('payment_types.index') }}">
                                    <i class="fa fa-credit-card me-1"></i>
                                    Payment Types
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Product List'))
                            <li>
                                <a class="{{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Products
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('ProductGroup List'))
                            <li>
                                <a class="{{ request()->is('product-groups*') ? 'active' : '' }}" href="{{ route('product-groups.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Product Groups
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Product Variation List'))
                            <li>
                                <a class="{{ request()->is('product-variations*') ? 'active' : '' }}" href="{{ route('product-variations.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Product Variations
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Purchase Requisition List'))
                            <li>
                                <a class="{{ request()->is('purchase-requisitions*') ? 'active' : '' }}" href="{{ route('purchase-requisitions.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Manual Purchase Requisitions
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Raw Material Item List'))
                            <li>
                                <a class="{{ request()->is('raw-material-items*') ? 'active' : '' }}" href="{{ route('raw-material-items.index') }}">
                                    <i class="fa fa-layer-group me-1"></i>
                                    Raw Material Items
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Supplier List'))
                            <li>
                                <a class="{{ request()->is('suppliers*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Supplier
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Tax List'))
                            <li>
                                <a class="{{ request()->is('taxes*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Taxes
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(
                    auth()->user()->hasPermission('Finished Goods Receiving List') ||
                    auth()->user()->hasPermission('Goods Receiving List') ||
                    auth()->user()->hasPermission('Stock List')
                )
                <li class="submenu">
                    <a class="{{ request()->is('finished-goods-receivings*') ||
                        request()->is('goods-receivings*') ||
                        request()->is('stocks*') ? 'active' : ''}}" href="javascript:void(0);">
                        <span>Store</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('Finished Goods Receiving List'))
                            <li>
                                <a class="{{ request()->is('finished-goods-receiving*') ? 'active' : '' }}" href="{{ route('finished-goods-receivings.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                   Finished Goods Receiving Notes
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Goods Receiving List'))
                            <li>
                                <a class="{{ request()->is('goods-receivings*') ? 'active' : '' }}" href="{{ route('goods-receivings.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Goods Receiving Notes
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Left Over Note List'))
                            <li>
                                <a class="{{ request()->is('left-over-notes*') ? 'active' : '' }}" href="{{ route('left-over-notes.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Left Over Note
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Rejection Return Note List'))
                            <li>
                                <a class="{{ request()->is('rejection-return-notes*') ? 'active' : '' }}" href="{{ route('rejection-return-notes.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Rejection Return Note
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Stock List'))
                            <li>
                                <a class="{{ request()->is('stocks*') ? 'active' : '' }}" href="{{ route('stocks.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Stocks
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Store Issue Rquisition List'))
                            <li>
                                <a class="{{ request()->is('store-issue-requisitions*') ? 'active' : '' }}" href="{{ route('store-issue-requisitions.index') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Store Issue Rquisitions
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(
                    auth()->user()->hasPermission('Stock List')
                )
                <li class="submenu">
                    <a class="{{ request()->is('reports.balance-report*') ? 'active' : ''}}" href="javascript:void(0);">
                        <span>Reports</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('Stock List'))
                            <li>
                                <a class="{{ request()->is('reports.balance-report*') ? 'active' : '' }}" href="{{ route('reports.balance-report') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Balance Report
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Finished Goods Receiving List'))
                            <li>
                                <a class="{{ request()->is('reports.production-report*') ? 'active' : '' }}" href="{{ route('reports.production-report') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Production Report
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Invoice List'))
                            <li>
                                <a class="{{ request()->is('reports.purchase-items*') ? 'active' : '' }}" href="{{ route('reports.purchase-items') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Purchase Items
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Invoice List'))
                            <li>
                                <a class="{{ request()->is('reports.purchase-requisitions*') ? 'active' : '' }}" href="{{ route('reports.purchase-requisitions') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Purchase Requisition
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('Invoice List'))
                            <li>
                                <a class="{{ request()->is('reports.requirement-report*') ? 'active' : '' }}" href="{{ route('reports.requirement-report') }}">
                                    <i class="fa fa-store me-1"></i>
                                    Requirement Report
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- @if(auth()->user()->hasPermission('Parties List'))
                <li>
                    <a class="{{ request()->is('parties*') ? 'active' : '' }}" href="{{ route('parties.index') }}">
                        <i class="fa fa-users"></i>
                        <span>Parties</span>
                    </a>
                </li>
                @endif --}}

            </ul>
        </div>
    </div>
</div>
