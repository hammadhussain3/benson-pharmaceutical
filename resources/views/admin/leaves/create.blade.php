@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Leave</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Add Leave</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leaves.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee" class="js-example-basic-single select2" required @role('Superadmin') onchange="SelectCompany(this.value);" @endrole>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                        <!-- Assuming you have a full_name attribute -->
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <input type="text" class="form-control" id="company" value="{{ old('company') ? App\Models\Company::where('id', old('company'))->value('name') : '' }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ old('company') }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            @php
                                $currentMonth = date('n');
                                $currentYear = date('Y');
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
                                            <option value="{{ $key }}" {{ old('month', $currentMonth) == $key ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Year Dropdown -->
                                    <select class="form-select" name="year" id="year" onchange="SelectLoanDate(document.getElementById('month').value, this.value);">
                                        @for ($y = $currentYear; $y >= $currentYear - 9; $y--)
                                            <option value="{{ $y }}" {{ old('year', $currentYear) == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>                                
                            </div>
                            
                            @foreach ($leaveTypes as $key => $leaveType)
                                <div class="mb-3 col-md-6">
                                    <label for="days-{{ $key }}">{{ $leaveType->name }}</label>
                                    <input type="number" class="form-control" name="days[{{ $key }}]" id="days-{{ $key }}" 
                                        placeholder="Days" required value="{{ old('days.' . $key, 0) }}" min="0">
                                    <input type="hidden" name="leave_type[{{ $key }}]" value="{{ $leaveType->id }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection