@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Raw Material Item</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('raw-material-items.index') }}">Raw Material Items</a></li>
                    <li class="breadcrumb-item active">Edit Raw Material Item</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('raw-material-items.update', $rawMaterialItem->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" required value="{{ old('name', $rawMaterialItem->name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Code" required value="{{ old('code', $rawMaterialItem->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                    placeholder="Unit" required value="{{ old('unit', $rawMaterialItem->unit) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="min_level">Min Level</label>
                                <input type="text" class="form-control" name="min_level" id="min_level"
                                    placeholder="Min Level" required value="{{ old('min_level',$rawMaterialItem->min_level) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="max_level">Max Level</label>
                                <input type="text" class="form-control" name="max_level" id="max_level"
                                    placeholder="Max Level" required value="{{ old('max_level',$rawMaterialItem->max_level) }}">
                            </div>
                            @role('Superadmin')
                                <div class="mb-3 col-md-6">
                                    <label for="company">Company</label>
                                    <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectSuppliers(this.value); createRawMaterialItemCode(this.value);" @endrole>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company', $rawMaterialItem->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="supplier_id">Supplier</label>
                                <select name="party" id="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @php
                                        $selectedCompanyId = old('company', $rawMaterialItem->company_id);
                                    @endphp
                                    @foreach ($parties->where('company_id', $selectedCompanyId) as $party)
                                        <option value="{{ $party->id }}"
                                            {{ $party->id == old('party', $rawMaterialItem->party_id) ? 'selected' : '' }}>
                                            {{ $party->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('raw-material-items.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection