@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Salary</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salaries</a></li>
                    <li class="breadcrumb-item active">Edit Salary</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary_slips.update', $salarySlip->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee_id" class="js-example-basic-single select2" required onchange="SelectLoan(this.value); SelectLeaves(this.value, document.getElementById('year').value, document.getElementById('month').value); SelectIncomeTax(this.value); SelectLoanDate(document.getElementById('month').value, document.getElementById('year').value); @role('Superadmin') SelectCompany(this.value); @endrole SelectEmployeeDetails(this.value);">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee', $salarySlip->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>

                            @php
                                $currentMonth = date('n'); // Current month (1-12)
                                $currentYear = date('Y'); // Current year
                                $selectedMonth = old('month', $salarySlip->month ?? $currentMonth);
                                $selectedYear = old('year', $salarySlip->year ?? $currentYear);
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
                                            <option value="{{ $key }}" {{ $key == $selectedMonth ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Year Dropdown -->
                                    <select class="form-select" name="year" id="year" onchange="SelectLoanDate(document.getElementById('month').value, this.value); SelectLeaves(document.getElementById('employee_id').value, this.value, document.getElementById('month').value);">
                                        @for($year = $currentYear - 9; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="invalid-feedback">Please select a valid month and year.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_mode', $salarySlip->payment_mode) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                    <option value="cash" {{ old('payment_mode', $salarySlip->payment_mode) == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears"
                                    value="{{ old('arrears', $salarySlip->arrears) }}" required>
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" value="{{ old('late_in_early_out_deduction', $salarySlip->late_in_early_out_deduction) }}"
                                    required>
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime"
                                    value="{{ old('overtime', $salarySlip->overtime) }}" required>
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="eob">EOBI</label>
                                <input type="number" class="form-control" name="eob" id="eob" required value="{{ old('eob', $salarySlip->eob) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" class="form-control" name="income" id="basic_pay"
                                    value="{{ old('income', ($salarySlip->income == 0 ? $currentEmployee->basic_pay : $salarySlip->income)) }}" required>
                                <div class="invalid-feedback">Please provide the number of basic pay.</div>
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
                            @php
                                $allowanceNames = old('allowance_names', $salaryAllowances->pluck('name')->toArray());
                                $allowanceAmounts = old('allowance_amounts', $salaryAllowances->pluck('amount')->toArray());
                            @endphp

                            @foreach ($allowanceNames as $index => $name)
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="allowance_names[]" placeholder="Allowance Name" value="{{ $name }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" name="allowance_amounts[]" placeholder="Amount" value="{{ $allowanceAmounts[$index] ?? '' }}" class="form-control" required>
                                </div>
                            @endforeach
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
                            @php
                                $deductionNames = old('deduction_names', $salaryDeductions->pluck('name')->toArray());
                                $deductionAmounts = old('deduction_amounts', $salaryDeductions->pluck('amount')->toArray());
                            @endphp

                            @foreach ($deductionNames as $index => $name)
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="deduction_names[]" placeholder="Deduction Name" value="{{ $name }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" name="deduction_amounts[]" placeholder="Amount" value="{{ $deductionAmounts[$index] ?? '' }}" class="form-control" required>
                                </div>
                            @endforeach
                        </div>

                        <div class="row" id="formContainer">

                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax"
                                    value="{{ old('income_tax', $salarySlip->income_tax) }}" required>
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance"
                                    value="{{ old('loan_advance', $salarySlip->loan_advance) }}" required readonly >
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="allowances"
                                    value="{{ old('allowances', $currentEmployee->allowances) }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of allowances.</div>
                            </div>

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                @php
                                    $selectedCompanyId = old('company', $currentEmployee->company_id);
                                @endphp
                                <input type="text" class="form-control" id="company" value="{{ App\Models\Company::where('id', $selectedCompanyId)->value('name') }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ $selectedCompanyId }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $currentEmployee->company_id }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="branch">Branch</label>
                                <input type="text" class="form-control" name="branch" id="branch" required readonly value="{{ old('branch', $singleBranch->name) }}">
                                <input type="hidden" name="branch_id" id="branch_id" required value="{{ old('branch_id', $singleBranch->id) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department" required readonly value="{{ old('department', $singleDepartment->name) }}">
                                <input type="hidden" name="department_id" id="department_id" required value="{{ old('department_id', $singleDepartment->id) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" name="designation" id="designation" required readonly value="{{ old('designation', $singleDesignation->name) }}">
                                <input type="hidden" name="designation_id" id="designation_id" required value="{{ old('designation_id', $singleDesignation->id) }}">
                            </div>    

                            @php
                                $leaveTypes = App\Models\LeaveType::where('company_id', old('company', $salarySlip->company_id))->get();
                                $savedLeaves = old('leaves', $salarySlip->leaves) ?? [];
                                $savedLeavesId = old('leave_id', $salarySlip->leaves) ?? [];
                            @endphp

                            @foreach ($leaveTypes as $index => $leave)
                                <div class="mb-3 col-md-6 leaves">
                                    <label for="leaves_{{ $leave->id }}">{{ $leave->name }}</label>
                                    <input type="number" class="form-control" name="leaves[]" id="leaves_{{ $leave->id }}" value="{{ old('leaves')[$index] ?? ($savedLeaves[$index]['days'] ?? 0) }}" required readonly>
                                    <input type="hidden" name="leave_id[]" id="leave_id_{{ $leave->id }}" value="{{ old('leave_id')[$index] ?? $savedLeavesId[$index]['id'] ?? 0 }}">
                                </div>
                            @endforeach

                            @if(auth()->user()->hasPermission('Document Approval Edit'))
                                <div class="mb-3 col-md-6">
                                    <label for="is_approved">Is Approved</label>
                                    <select name="is_approved" id="is_approved" class="form-control" required>
                                        <option value="1" {{ old('is_approved', $salarySlip->is_approved) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_approved', $salarySlip->is_approved) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('salary_slips.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection