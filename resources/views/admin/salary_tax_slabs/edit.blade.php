@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Salary Tax Slab</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tax-slabs.index') }}">Salary Tax Slabs</a></li>
                    <li class="breadcrumb-item active">Edit Salary Tax Slab</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tax-slabs.update', $taxSlab->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-4">
                                <label for="slab_start">Slab Start</label>
                                <input type="number" class="form-control" name="slab_start" id="slab_start"
                                    value="{{ $taxSlab->slab_start }}" required>
                                <div class="invalid-feedback">Please provide the slab start value.</div>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="slab_end">Slab End</label>
                                <input type="number" class="form-control" name="slab_end" id="slab_end"
                                    value="{{ $taxSlab->slab_end }}" required>
                                <div class="invalid-feedback">Please provide the slab end value.</div>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="tax_value">Tax Value (%)</label>
                                <input type="number" class="form-control" name="tax_value" id="tax_value"
                                    value="{{ $taxSlab->tax_value }}" required>
                                <div class="invalid-feedback">Please provide the tax value in percentage.</div>
                            </div>

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select class="js-example-basic-single select2" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $taxSlab->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ $taxSlab->company_id }}">
                            @endrole
                        </div>

                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('tax-slabs.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
