@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Left Over Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('left-over-notes.index') }}">Left Over Notes</a></li>
                    <li class="breadcrumb-item active">Edit Left Over Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('left-over-notes.update', $leftOverNote->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProducts(this.value); selectDepartments(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $leftOverNote->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <input type="hidden" name="company" id="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-4">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $leftOverNote->code) }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="product_id">Product</label>
                                <select class="js-example-basic-single select2" name="product" id="product_id" required onchange="selectBatches(this.value); selectProductionStoreRequisitions(document.getElementById('company_id').value, this.value);">
                                    <option value="">Select Product</option>
                                    @php
                                        $seletedCompanyId = old('company', $leftOverNote->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($products->where('company_id', $seletedCompanyId) as $products)
                                        <option value="{{ $products->id }}"
                                            {{ old('product', $leftOverNote->product_id) == $products->id ? 'selected' : '' }}>
                                            {{ $products->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="batch_id">Batch</label>
                                <select class="js-example-basic-single select2" name="batch" id="batch_id" required>
                                    <option value="">Select Batch</option>
                                    @php
                                        $seletedProductId = old('product', $leftOverNote->product_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($batches->where('product_id', $seletedProductId) as $batch)
                                        <option value="{{ $batch->id }}"
                                            {{ old('batch', $leftOverNote->batch_id) == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->batch_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department_id">Department</label>
                                <select name="department" id="department_id" class="form-control" required value="{{ old('department') }}">
                                    <option value="">Select Department</option>
                                    @php
                                        $seletedCompanyId = old('company', $leftOverNote->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($departments->where('company_id', $seletedCompanyId) as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department', $leftOverNote->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="store_issue_requisition_id">Store Issue Requisition</label>
                                <select name="store_issue_requisition" id="store_issue_requisition_id" class="js-example-basic-single select2" required onchange="getProductionStoreRequisitionDetails(this.value)">
                                    <option value="">Select Store Issue Requisition</option>
                                    @php
                                        $seletedCompanyId = old('company', $leftOverNote->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($requisitions->where('company_id', $seletedCompanyId)->where('is_production', '1') as $requisition)
                                        <option value="{{ $requisition->id }}"
                                            {{ old('store_issue_requisition', $leftOverNote->store_issue_requisition_id) == $requisition->id ? 'selected' : '' }}>
                                            {{ $requisition->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @if (count(old('items', $leftOverNote->items)) > 0)
                                        @foreach (old('items', $leftOverNote->items) as $i => $item)
                                            <div class="item-set">
                                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="card-body px-0 pb-0">
                                                    <div class="row">
                                                        <div class="mb-3 col-md">
                                                            <label for="raw_material_item_name">Description</label>
                                                            <input type="text" class="form-control" name="items[{{ $i }}][name]"
                                                                   placeholder="Description" required value="{{ old('items.'.$i.'.name', $leftOverNote->items[$i]->rawMaterialItem->name) }}" readonly>
                                                            <input type="hidden" name="items[{{ $i }}][raw_material_item]" 
                                                                value="{{ old('items.'.$i.'.raw_material_item', $leftOverNote->items[$i]->raw_material_item_id) }}">
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Unit Price</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                       placeholder="Unit Price" required value="{{ old("items.$i.unit_price", $leftOverNote->items[$i]->unit_price) }}" readonly>
                                                                <input type="text" class="form-control" name="items[{{ $i }}][unit]"
                                                                       placeholder="Unit" required value="{{ old("items.$i.unit", $leftOverNote->items[$i]->unit) }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Quantity</label>
                                                            <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                                   placeholder="Quantity" required 
                                                                   value="{{ old("items.$i.quantity", $leftOverNote->items[$i]->quantity) }}" 
                                                                   max="{{ old("items.$i.max_quantity", $leftOverNote->items[$i]->quantity) }}"
                                                                   min="1" oninput="calculateSingleProductAmount()">
                                                            <input type="hidden" name="items[{{ $i }}][max_quantity]" value="{{ old("items.$i.max_quantity", $leftOverNote->items[$i]->quantity) }}">
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Total</label>
                                                            <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                                   placeholder="Total" required value="{{ old("items.$i.total", $leftOverNote->items[$i]->total) }}" readonly>
                                                        </div>
                                                        <div class="mb-3 col-12">
                                                            <label>Remarks</label>
                                                            <textarea class="form-control" name="items[{{ $i }}][remarks]" placeholder="Write your remarks..." required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2 mb-3">
                                                <p class="mb-0 text-center">No data is showing.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <a class="btn btn-secondary" href="{{ route('left-over-notes.index') }}">Cancel</a>
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
    <script>
        function removeItem(button) {
            const itemSets = document.querySelectorAll('#item-group .item-set');
            // Find the closest parent .item-set of the clicked button and remove it
            if (itemSets && itemSets.length > 1) {
                const item = button.closest('.item-set');
                if (item) {
                    item.remove();
                    itemIndex--; // Decrement itemIndex to ensure consistency
                }
            }
        }
    </script>
@endsection