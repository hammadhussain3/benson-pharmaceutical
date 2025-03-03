@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Salary</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salaries</a></li>
                    <li class="breadcrumb-item active">Add Salary</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary_slips.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-6">
                                <label>Select Employee </label>
                                <select name="employee" id="employee_id" class="js-example-basic-single select2" required onchange="SelectEob(this.value); SelectLoan(this.value); SelectLeaves(this.value, document.getElementById('year').value, document.getElementById('month').value); SelectIncomeTax(this.value); SelectLoanDate(document.getElementById('month').value, document.getElementById('year').value); @role('Superadmin') SelectCompany(this.value); @endrole SelectEmployeeDetails(this.value);">
                                    <option value="">--Select Employee--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} -
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $currentMonth = date('n');
                                $currentYear = date('Y');
                            @endphp
                            <div class="mb-3 col-md-6">
                                <label for="month-year">Month and Year</label>
                                <div class="input-group">
                                    <!-- Month Dropdown -->
                                    <select class="form-select" name="month" id="month" onchange="SelectLoanDate(this.value, document.getElementById('year').value); SelectLeaves(document.getElementById('employee_id').value, document.getElementById('year').value, this.value);">
                                        @foreach([
                                            '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April',
                                            '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August',
                                            '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                                        ] as $key => $month)
                                            <option value="{{ $key }}" {{ old('month', $currentMonth) == $key ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Year Dropdown -->
                                    <select class="form-select" name="year" id="year" onchange="SelectLoanDate(document.getElementById('month').value, this.value); SelectLeaves(document.getElementById('employee_id').value, this.value, document.getElementById('month').value);">
                                        @for ($y = $currentYear; $y >= $currentYear - 9; $y--)
                                            <option value="{{ $y }}" {{ old('year', $currentYear) == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>                                
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label for="month">Month</label>
                                <input type="month" name="month" id="month" class="form-control" max="{{ date('Y-m', strtotime('-1 month')) }}" required onchange="SelectLoanDate(this.value);">
                                <div class="invalid-feedback">Please select a month.</div>
                            </div> --}}

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears" required value="{{ old('arrears') }}">
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" required value="{{ old('late_in_early_out_deduction') }}">
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime" required value="{{ old('overtime') }}">
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="eob">E.O.B</label>
                                <input type="number" class="form-control" name="eob" id="eob" required value="{{ old('eob') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Income</label>
                                <input type="number" class="form-control" name="income" id="basic_pay" required value="{{ old('income') }}">
                            </div>
                        </div>
                        
                        <div class="row" id="allowance-container">
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <h3 class="fs-6 fw-bold">Allowances</h3>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="badge border-0 bg-transparent link-primary" onclick="addAllowance()">+ Add Allowance</button>
                                    </div>
                                </div>
                            </div>
                            @if(old('allowance_names'))
                                @foreach (old('allowance_names') as $index => $name)
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="allowance_names[]" placeholder="Allowance Name" value="{{ $name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" name="allowance_amounts[]" placeholder="Amount" value="{{ old('allowance_amounts')[$index] }}" class="form-control" required>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    
                        <div class="row" id="deduction-container">
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <h3 class="fs-6 fw-bold">Deductions</h3>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="badge border-0 bg-transparent link-primary" onclick="addDeduction()">+ Add Deduction</button>
                                    </div>
                                </div>
                            </div>
                            @if(old('deduction_names'))
                                @foreach (old('deduction_names') as $index => $name)
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="deduction_names[]" placeholder="Deduction Name" value="{{ $name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" name="deduction_amounts[]" placeholder="Amount" value="{{ old('deduction_amounts')[$index] }}" class="form-control" required>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="row" id="formContainer">
                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax" required readonly value="{{ old('income_tax') }}">
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance" required readonly value="{{ old('loan_advance') }}">
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="allowances" required readonly value="{{ old('allowances') }}">
                                <div class="invalid-feedback">Please provide the number of allowances.</div>
                            </div>

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" required readonly value="{{ old('company') ? App\Models\Company::where('id', old('company'))->value('name') : '' }}">
                                <input type="hidden" name="company" id="company_id" required value="{{ old('company') }}">
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="branch">Branch</label>
                                <input type="text" class="form-control" name="branch" id="branch" required readonly value="{{ old('branch') }}">
                                <input type="hidden" name="branch_id" id="branch_id" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department" required readonly value="{{ old('department') }}">
                                <input type="hidden" name="department_id" id="department_id" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" name="designation" id="designation" required readonly value="{{ old('designation') }}">
                                <input type="hidden" name="designation_id" id="designation_id" required>
                            </div>

                            @if (old('employee') || old('leaves'))
                                @php
                                    $leaveTypes = App\Models\LeaveType::where('company_id', old('company'))->get();
                                    $oldLeaves = old('leaves', []);
                                    $oldLeavesId = old('leave_id', []);
                                @endphp

                                @foreach ($leaveTypes as $index => $leave)
                                    <div class="mb-3 col-md-6 leaves">
                                        <label for="leaves_{{ $leave->id }}">{{ $leave->name }}</label>
                                        <input type="number" class="form-control" name="leaves[]" id="leaves_{{ $leave->id }}" value="{{ $oldLeaves[$index] ?? 0 }}" required readonly>
                                        <input type="hidden" name="leave_id[]" id="leave_id_{{ $leave->id }}" value="{{ $oldLeavesId[$index] ?? 0 }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('salary_slips.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection