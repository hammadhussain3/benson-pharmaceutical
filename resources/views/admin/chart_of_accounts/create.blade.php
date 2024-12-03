@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Chart of Account</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('chart_of_accounts.index') }}">Chart of Accounts</a></li>
                    <li class="breadcrumb-item active">Add Chart of Account</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('chart_of_accounts.store') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-6">
                                    <label for="company">Company</label>
                                    <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="createChartOfAccountCode(this.value);" @endrole>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a company.</div>
                                </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code"
                                    required value="{{ old('code', $newChartOfAccountCode) }}" readonly>
                                <div class="invalid-feedback">Please provide a valid code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="particular">Particular</label>
                                <input type="text" class="form-control" name="particular" id="particular" placeholder="Name Or Description"
                                    required value="{{ old('particular') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="abbreviation">Abbreviation</label>
                                <input type="text" class="form-control" name="abbreviation" id="abbreviation" placeholder="Abbreviation"
                                    required value="{{ old('abbreviation') }}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('chart_of_accounts.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
