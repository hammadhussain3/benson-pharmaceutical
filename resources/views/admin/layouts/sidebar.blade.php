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
                    <li><span class="fst-italic fw-bold" style="color: #ff9f43;">Admin</span></li>
                @endif

                @if(auth()->user()->hasPermission('Bank List'))
                    <li>
                        <a class="{{ request()->is('banks*') ? 'active' : '' }}" href="{{ route('banks.index') }}">
                            <i class="fa fa-building"></i>
                            <span>Banks</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Branches List'))
                    <li>
                        <a class="{{ request()->is('branches*') ? 'active' : '' }}" href="{{ route('branches.index') }}">
                            <i class="fa fa-code-branch"></i>
                            <span>Branches</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Cities List'))
                    <li>
                        <a class="{{ request()->is('cities*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
                            <i class="fa fa-city"></i>
                            <span>Cities</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Companies List'))
                    <li>
                        <a class="{{ request()->is('companies*') ? 'active' : '' }}" href="{{ route('companies.index') }}">
                            <i class="fa fa-building"></i>
                            <span>Companies</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Countries List'))
                    <li>
                        <a class="{{ request()->is('countries*') ? 'active' : '' }}" href="{{ route('countries.index') }}">
                            <i class="fa fa-globe"></i>
                            <span>Countries</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Departments List'))
                    <li>
                        <a class="{{ request()->is('departments*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                            <i class="fa fa-sitemap"></i>
                            <span>Departments</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Roles List'))
                    <li>
                        <a class="{{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <i class="fa fa-lock"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('Users List'))
                    <li>
                        <a class="{{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fa fa-user"></i>
                            <span>Users</span>
                        </a>
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
                    <li><span class="fst-italic fw-bold" style="color: #ff9f43;">Human Resource</span></li>
                @endif

                <li>
                    <a class="{{ request()->is('designations*') ? 'active' : '' }}" href="{{ route('designations.index') }}">
                        <i class="fa fa-briefcase"></i>
                        <span>Designations</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('employees*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        <i class="fa fa-users"></i>
                        <span>Employees</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('leaves*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                        <i class="fa fa-calendar"></i>
                        <span>Leave</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('leave_types*') ? 'active' : '' }}"
                        href="{{ route('leave_types.index') }}">
                        <i class="fa fa-tags"></i>
                        <span>Leave Type</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('loans*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                        <i class="fa fa-handshake"></i>
                        <span>Loan</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('salary_slips*') ? 'active' : '' }}"
                        href="{{ route('salary_slips.index') }}">
                        <i class="fa fa-calculator"></i>
                        <span>Salaries</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('tax-slabs*') ? 'active' : '' }}" href="{{ route('tax-slabs.index') }}">
                        <i class="fa fa-handshake"></i>
                        <span>Salary Tax Slabs</span>
                    </a>
                </li>

                {{-- <li>
                    <a class="{{ request()->is('salary-sheet*') ? 'active' : '' }}"
                        href="{{ route('salary.sheet.index') }}">
                        <i class="fa fa-book"></i>
                        <span>Salary Sheet</span>
                    </a>
                </li> --}}

                <li>
                    <a class="{{ request()->is('chart_of_accounts*') ? 'active' : '' }}" href="{{ route('chart_of_accounts.index') }}">
                        <i class="fa fa-list-alt"></i>
                        <span>Chart of Accounts</span>
                    </a>
                </li>
                
                <li>
                    <a class="{{ request()->is('parties*') ? 'active' : '' }}" href="{{ route('parties.index') }}">
                        <i class="fa fa-users"></i>
                        <span>Parties</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('payment_types*') ? 'active' : '' }}" href="{{ route('payment_types.index') }}">
                        <i class="fa fa-credit-card"></i>
                        <span>Payment Types</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
