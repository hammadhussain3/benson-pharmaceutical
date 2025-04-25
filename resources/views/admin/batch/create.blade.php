@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Batch</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('batches.index') }}">Batch</a></li>
                    <li class="breadcrumb-item active">Add Batch</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('batches.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="form-control" required value="{{ old('company') }}" @role('Superadmin') onchange="selectProducts(this.value);" @endrole>
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
                                <label for="product_id">Product</label>
                                <select class="js-example-basic-single select2" name="product" id="product_id" required>
                                    <option value="">Select Product</option>
                                    @if(old('product') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($products->where('company_id', $seletedCompanyId) as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product') == $product->id ? 'selected' : '' }}>
                                                {{ $product->brand_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="batch_no">Batch No</label>
                                <input type="text" class="form-control" name="batch_no" id="batch_no"
                                    placeholder="Batch No" required value="{{ old('batch_no') }}">
                                <div class="invalid-feedback">Please provide a Batch No.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="batch_size">Batch Size</label>
                                <input type="text" class="form-control" name="batch_size" id="batch_size"
                                    placeholder="Batch Size" required value="{{ old('batch_size') }}">
                                <div class="invalid-feedback">Please provide a Batch Size.</div>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="description">Manufactured Date</label>
                                <input type="date" class="form-control" name="mfg_date"
                                    required value="{{ old('mfg_date') }}">
                                <div class="invalid-feedback">Please provide a Manufactured Date.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="description">Expiry Date</label>
                                <input type="date" class="form-control" name="exp_date"
                                    required value="{{ old('exp_date') }}">
                                <div class="invalid-feedback">Please provide a Expiry Date.</div>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Status</label>
                                <select class="js-example-basic-single select2" name="status" required>
                                        <option value="inprocess">
                                            In-Process
                                        </option>
                                        <option value="completed">
                                            Completed
                                        </option>
                                </select>
                                <div class="invalid-feedback">Please select a Status.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('categories.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
