@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Leave</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Edit Leave</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leaves.update', $leave->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                @php
                                    $selectedCompanyId = old('company', $leave->company_id);
                                @endphp
                                <input type="text" class="form-control" id="company" value="{{ App\Models\Company::where('id', $selectedCompanyId)->value('name') }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ $selectedCompanyId }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $leave->company_id }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee" class="js-example-basic-single select2" required @role('Superadmin') onchange="SelectCompany(this.value);" @endrole>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee', $leave->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>

                            @php
                                $currentMonth = date('n'); // Current month (1-12)
                                $currentYear = date('Y'); // Current year
                                $selectedMonth = old('month', isset($leave->created_at) ? \Carbon\Carbon::parse($leave->created_at)->month : $currentMonth);
                                $selectedYear = old('year', isset($leave->created_at) ? \Carbon\Carbon::parse($leave->created_at)->year : $currentYear);
                            @endphp

                            <div class="mb-3 col-md-6">
                                <label for="month-year">Month and Year</label>
                                <div class="input-group">
                                    <!-- Month Dropdown -->
                                    <select class="form-select" name="month" id="month" onchange="SelectLoanDate(this.value, document.getElementById('year').value);">
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
                                    <select class="form-select" name="year" id="year" onchange="SelectLoanDate(document.getElementById('month').value, this.value);">
                                        @for($year = $currentYear - 9; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="invalid-feedback">Please select a valid month and year.</div>
                            </div>
                            
                            @foreach ($leaveTypes as $key => $leaveType)
                                @php
                                    $leaveRecord = $leaves->where('leave_type_id', $leaveType->id)->first();
                                    $existingDays = $leaveRecord ? $leaveRecord->days : 0; // Default to 0 if not found
                                @endphp

                                <div class="mb-3 col-md-6">
                                    <label for="days-{{ $key }}">{{ $leaveType->name }}</label>
                                    <input type="number" class="form-control" name="days[{{ $key }}]" id="days-{{ $key }}" 
                                        placeholder="Days" required value="{{ old('days.' . $key, $existingDays) }}" min="0">
                                    <input type="hidden" name="leave_type[{{ $key }}]" value="{{ $leaveType->id }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
