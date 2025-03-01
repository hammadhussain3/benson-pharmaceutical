@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Leave Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Leave Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label for="name">Employee</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name">Company</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->company->name }}" readonly>
                        </div>
                        @php
                            $currentMonth = date('n');
                            $currentYear = date('Y'); // Current year
                            $selectedMonth = isset($leave->created_at) ? \Carbon\Carbon::parse($leave->created_at)->month : $currentMonth;
                            $selectedYear = isset($leave->created_at) ? \Carbon\Carbon::parse($leave->created_at)->year : $currentYear;
                        @endphp

                        <div class="mb-3 col-md-6">
                            <label for="month-year">Month and Year</label>
                            <div class="input-group">
                                <!-- Month Dropdown -->
                                <select class="form-select" name="month" id="month" onchange="SelectLoanDate(this.value, document.getElementById('year').value);" disabled>
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
                                <select class="form-select" name="year" id="year" onchange="SelectLoanDate(document.getElementById('month').value, this.value);" disabled>
                                    @for($year = $currentYear - 9; $year <= $currentYear; $year++)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        @foreach ($leaveTypes as $key => $leaveType)
                            @php
                                $leaveRecord = $leaves->where('leave_type_id', $leaveType->id)->first();
                                $existingDays = $leaveRecord ? $leaveRecord->days : 0; // Default to 0 if not found
                            @endphp

                            <div class="mb-3 col-md-6">
                                <label for="days-{{ $key }}">{{ $leaveType->name }}</label>
                                <input type="number" class="form-control" id="days-{{ $key }}" value="{{ $existingDays }}" readonly>
                            </div>
                        @endforeach
                    </div>
                    <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection