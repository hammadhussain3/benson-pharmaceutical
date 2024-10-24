@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Generate Salary Sheet</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary.sheet.index') }}">Salary Sheets</a></li>
                    <li class="breadcrumb-item active">Generate Salary Sheet</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary.sheet.show') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Select Employee </label>
                                <select name="employee_id" id="employee" class="js-example-basic-single select2">
                                    <option value="">--Select Employee--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->code }} -
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="month">Month</label>
                                <input type="month" name="month" id="month" class="form-control" required>
                                <div class="invalid-feedback">Please select a month.</div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Generate Salary Sheet</button>
                        <a class="btn btn-secondary" href="{{ route('salary.sheet.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
