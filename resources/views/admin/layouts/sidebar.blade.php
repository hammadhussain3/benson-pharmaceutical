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

                @role('Superadmin')

                <li><span class="fst-italic fw-bold" style="color: #ff9f43;">Admin</span></li>

                <li class="submenu">
                    <a class=" {{ request()->is('countries*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-globe"></i>
                        <span>Countries</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('countries') ? 'active' : '' }}"
                                href="{{ route('countries.index') }}">Country List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('countries/create') ? 'active' : '' }}"
                                href="{{ route('countries.create') }}">Add Country</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('cities*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-city"></i>
                        <span>Cities</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('cities') ? 'active' : '' }}"
                                href="{{ route('cities.index') }}">City List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('cities/create') ? 'active' : '' }}"
                                href="{{ route('cities.create') }}">Add City</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('companies*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-building"></i>
                        <span>Companies</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('companies') ? 'active' : '' }}"
                                href="{{ route('companies.index') }}">Company List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('companies/create') ? 'active' : '' }}"
                                href="{{ route('companies.create') }}">Add Company</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('branches*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-code-branch"></i>
                        <span>Branches</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('branches') ? 'active' : '' }}"
                                href="{{ route('branches.index') }}">Branch List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('branches/create') ? 'active' : '' }}"
                                href="{{ route('branches.create') }}">Add Branch</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('departments*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-sitemap"></i>
                        <span>Departments</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('departments') ? 'active' : '' }}"
                                href="{{ route('departments.index') }}">Department List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('departments/create') ? 'active' : '' }}"
                                href="{{ route('departments.create') }}">Add Department</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('users*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-user"></i>
                        <span>Users</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('users') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">User List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('users/register') ? 'active' : '' }}"
                                href="{{ route('users.register') }}">Add User</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('roles*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-lock"></i>
                        <span>Roles</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('roles') ? 'active' : '' }}"
                                href="{{ route('roles.index') }}">Role List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('roles/create') ? 'active' : '' }}"
                                href="{{ route('roles.create') }}">Add Role</a>
                        </li>
                    </ul>
                </li>

                @endrole

                <li><span class="fst-italic fw-bold" style="color: #ff9f43;">Human Resource</span></li>

                <li>
                    <a class="{{ request()->is('employees*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        <i class="fa fa-users"></i>
                        <span>Employees</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('loans*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                        <i class="fa fa-handshake"></i>
                        <span>Loan</span>
                    </a>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('tax-slabs*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-percent"></i>
                        <span>Salary Tax Slabs</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('tax-slabs') ? 'active' : '' }}"
                                href="{{ route('tax-slabs.index') }}">Tax Slab List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('tax-slabs/create') ? 'active' : '' }}"
                                href="{{ route('tax-slabs.create') }}">Add Tax Slab</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="{{ request()->is('leave_types*') ? 'active' : '' }}"
                        href="{{ route('leave_types.index') }}">
                        <i class="fa fa-tags"></i>
                        <span>Leave Type</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('leaves*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                        <i class="fa fa-calendar"></i>
                        <span>Leave</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('salary_slips*') ? 'active' : '' }}"
                        href="{{ route('salary_slips.index') }}">
                        <i class="fa fa-calculator"></i>
                        <span>Salaries</span>
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
                    <a class="{{ request()->is('banks*') ? 'active' : '' }}" href="{{ route('banks.index') }}">
                        <i class="fa fa-building"></i>
                        <span>Bank</span>
                    </a>
                </li>
                
                <li>
                    <a class="{{ request()->is('parties*') ? 'active' : '' }}" href="{{ route('parties.index') }}">
                        <i class="fa fa-users"></i>
                        <span>Parties</span>
                    </a>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('chart_of_accounts*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-list-alt"></i>
                        <span>Chart of Accounts</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('chart_of_accounts') ? 'active' : '' }}"
                                href="{{ route('chart_of_accounts.index') }}">Chart of Account List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('chart_of_accounts/create') ? 'active' : '' }}"
                                href="{{ route('chart_of_accounts.create') }}">Add Chart of Account</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('payment_types*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-credit-card"></i>
                        <span>Payment Types</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('payment_types') ? 'active' : '' }}"
                                href="{{ route('payment_types.index') }}">Payment Type List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('payment_types/create') ? 'active' : '' }}"
                                href="{{ route('payment_types.create') }}">Add Payment Type</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a class=" {{ request()->is('designations*') ? 'active' : '' }}" href="javascript:void(0);">
                        <i class="fa fa-briefcase"></i>
                        <span>Designations</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('designations') ? 'active' : '' }}"
                                href="{{ route('designations.index') }}">Designation List</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('designations/create') ? 'active' : '' }}"
                                href="{{ route('designations.create') }}">Add Designation</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
