@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Manual Purchase Requisition</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchase-requisitions.index') }}">Manual Purchase Requisitions</a></li>
                    <li class="breadcrumb-item active">Edit Manual Purchase Requisition</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchase-requisitions.update', $purchaseRequisition->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required onchange="selectSuppliers(this.value); createPurchaseRequisitionCode(this.value);">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $purchaseRequisition->company_id) == $company->id ? 'selected' : '' }}>
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
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $purchaseRequisition->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Date</label>
                                <input type="date" class="form-control" value="{{ $purchaseRequisition->created_at->format('Y-m-d') }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="required_date">Reqired Date</label>
                                <input type="date" class="form-control" name="required_date" id="required_date" value="{{ old('required_date', \Carbon\Carbon::parse($purchaseRequisition->required_date)->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier" id="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @php
                                        $selectedCompanyId = old('company', $purchaseRequisition->company_id);
                                    @endphp
                                    @foreach ($suppliers->where('company_id', $selectedCompanyId) as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == old('supplier', $purchaseRequisition->supplier_id) ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="productList">
                                        <thead>
                                            <tr>
                                                <th class="col-auto">#</th>
                                                <th class="col-md-4">Item</th>
                                                <th class="col-auto">Quantity</th>
                                                <th class="col-auto">Unit</th>
                                                <th class="col-auto">Price Per Unit</th>
                                                <th class="col-auto">Amount</th>
                                                <th class="col-auto">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $oldCount = max(
                                                    count(old('name', [])),
                                                    count(old('quantity', [])),
                                                    count(old('unit', [])),
                                                    count(old('price', [])),
                                                    count(old('amount', []))
                                                );
                                                $count = $oldCount > 0 ? $oldCount : count($purchaseRequisition->purchaseRequisitionItems);
                                            @endphp
                                            @for ($i = 0; $i < $count; $i++)
                                                <tr class="product-row">
                                                    <td>{{ $i + 1 }}</td>
                                                    <td><input type="text" class="form-control" name="name[]" placeholder="Item" value="{{ old('name')[$i] ?? ($purchaseRequisition->purchaseRequisitionItems[$i]->name ?? '') }}"></td>
                                                    <td><input type="number" class="form-control" name="quantity[]" placeholder="Quantity" value="{{ old('quantity')[$i] ?? ($purchaseRequisition->purchaseRequisitionItems[$i]->quantity ?? '') }}" min="0"></td>
                                                    <td>
                                                        <select name="unit[]" id="unit" class="form-control" style="min-width: 60px;">
                                                            <option value="Unit" {{ ((optional(old('unit'))[$i] ?? $purchaseRequisition->purchaseRequisitionItems[$i]->unit) == 'Unit') ? 'selected' : '' }}>Unit</option>
                                                            <option value="KG" {{ ((optional(old('unit'))[$i] ?? $purchaseRequisition->purchaseRequisitionItems[$i]->unit) == 'KG') ? 'selected' : '' }}>KG</option>
                                                            <option value="Litre" {{ ((optional(old('unit'))[$i] ?? $purchaseRequisition->purchaseRequisitionItems[$i]->unit) == 'Litre') ? 'selected' : '' }}>Litre</option>
                                                        </select>
                                                    <td><input type="number" class="form-control" name="price[]" placeholder="Price Per Unit" value="{{ old('price')[$i] ?? ($purchaseRequisition->purchaseRequisitionItems[$i]->price ?? '') }}" min="0"></td>
                                                    <td><input type="number" class="form-control" name="amount[]" placeholder="Amount" value="{{ old('amount')[$i] ?? ($purchaseRequisition->purchaseRequisitionItems[$i]->amount ?? '') }}" min="0" oninput="calculateTotalAmount()"></td>
                                                    <td>
                                                        @if ($i > 0)
                                                            <button type="button" class="btn btn-danger btn-sm removeProductButton" onclick="removeProductRow(this)"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                            <tr>
                                                <td colspan="5">Total</td>
                                                <td><input type="number" class="form-control" name="total_amount" id="total_amount" value="{{ old('total_amount', $purchaseRequisition->total_amount) }}" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mt-1" id="addProductButton">Add Row</button>
                                </div>
                            </div>  
                            @if(auth()->user()->hasPermission('Status Update'))
                            <div class="mb-3 col-md-6">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Pending" {{ old('special_instructions', $purchaseRequisition->special_instructions) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Partial" {{ old('special_instructions', $purchaseRequisition->special_instructions) == 'Partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="Complete" {{ old('special_instructions', $purchaseRequisition->special_instructions) == 'Complete' ? 'selected' : '' }}>Complete</option>
                                </select>
                            </div> 
                            @endif
                            <div class="mb-3 col-md-12">
                                <label for="special_instructions">Special Instruction</label>
                                <textarea class="form-control" name="special_instructions" id="special_instructions">{{ old('special_instructions', $purchaseRequisition->special_instructions) }}</textarea>
                            </div>
                        </div>
                        <a class="btn btn-secondary" href="{{ route('purchase-requisitions.index') }}">Cancel</a>
                        <input type="hidden" name="is_approved" id="is_approved" value="0">

                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('is_approved').value = 0;">
                            Save
                        </button>

                        @if(auth()->user()->hasPermission('Document Approval Edit'))
                            <button type="submit" class="btn btn-success" onclick="document.getElementById('is_approved').value = 1;">
                                Approve
                            </button>
                        @endif
                        
                    </form>
                </div>
            </div>
        </div>
    </div> 
@endsection