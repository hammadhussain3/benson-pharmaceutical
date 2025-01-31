@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Salary Tax Slab Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tax-slabs.index') }}">Salary Tax Slabs</a></li>
                    <li class="breadcrumb-item active">Salary Tax Slab Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label for="name">Slab Start</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->slab_start }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Slab End</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->slab_end }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Tax Value</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->tax_value }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Country Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->company->name }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('tax-slabs.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection