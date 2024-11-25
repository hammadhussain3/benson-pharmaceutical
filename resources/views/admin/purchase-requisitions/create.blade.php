@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Manual Purchase Requisition</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchase-requisitions.index') }}">Manual Purchase Requisitions</a></li>
                    <li class="breadcrumb-item active">Add Manual Purchase Requisition</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchase-requisitions.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required onchange="selectSuppliers(this.value); createPurchaseRequisitionCode(this.value);">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-4">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $newPurchaseRequisitionCode) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Date</label>
                                <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="required_date">Reqired Date</label>
                                <input type="date" class="form-control" name="required_date" id="required_date" value="{{ old('required_date') }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier" id="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @if(old('supplier') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($suppliers->where('company_id', $seletedCompanyId) as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="productList">
                                        <thead>
                                            <tr>
                                                <th class="col-auto">#</th>
                                                <th class="col-md-4">Name</th>
                                                <th class="col-auto">Quantity</th>
                                                <th class="col-auto">Unit</th>
                                                <th class="col-auto">Price</th>
                                                <th class="col-auto">Amount</th>
                                                <th class="col-auto">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = max(
                                                    count(old('name', [])),
                                                    count(old('quantity', [])),
                                                    count(old('unit', [])),
                                                    count(old('price', [])),
                                                    count(old('amount', [])),
                                                    1
                                                );
                                            @endphp
                                            @for ($i = 0; $i < $count; $i++)
                                                <tr class="product-row">
                                                    <td>{{ $i + 1 }}</td>
                                                    <td><input type="text" class="form-control" name="name[]" placeholder="Name" value="{{ old('name')[$i] ?? '' }}"></td>
                                                    <td><input type="number" class="form-control" name="quantity[]" placeholder="Quantity" value="{{ old('quantity')[$i] ?? '' }}" min="0" oninput="calculateRowAmount(this)"></td>
                                                    <td><input type="text" class="form-control" name="unit[]" placeholder="Unit" value="{{ old('unit')[$i] ?? '' }}"></td>
                                                    <td><input type="number" class="form-control" name="price[]" placeholder="Price" value="{{ old('price')[$i] ?? '' }}" min="0" oninput="calculateRowAmount(this)"></td>
                                                    <td><input type="number" class="form-control" name="amount[]" placeholder="Amount" value="{{ old('amount')[$i] ?? '' }}" min="0" oninput="calculateTotalAmount()" readonly></td>
                                                    <td>
                                                        @if ($i > 0)
                                                            <button type="button" class="btn btn-danger btn-sm removeProductButton" onclick="removeProductRow(this)"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                            <tr>
                                                <td colspan="5">Total</td>
                                                <td><input type="number" class="form-control" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mt-1" id="addProductButton">Add Row</button>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="special_instructions">Special Instruction</label>
                                <textarea class="form-control" name="special_instructions" id="special_instructions">{{ old('special_instructions') }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('purchase-requisitions.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div> 
@endsection