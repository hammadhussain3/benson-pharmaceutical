@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Rejection Return Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rejection-return-notes.index') }}">Rejection Return Notes</a></li>
                    <li class="breadcrumb-item active">Edit Rejection Return Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rejection-return-notes.update', $rejectionReturnNote->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectInvoices(this.value); selectGeneralStoreRequisitions(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $rejectionReturnNote->company_id) == $company->id ? 'selected' : '' }}>
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
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $rejectionReturnNote->code) }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="invoice_id">Invoice</label>
                                <select name="invoice" id="invoice_id" class="js-example-basic-single select2" required onchange="selectSupplierByInvoice(this.value); selectSupplierBillNoByInvoice(this.value);">
                                    <option value="">Select Invoice</option>
                                    @php
                                        $seletedCompanyId = old('company', $rejectionReturnNote->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($invoices->where('company_id', $seletedCompanyId) as $invoice)
                                        <option value="{{ $invoice->id }}"
                                            {{ old('invoice', $rejectionReturnNote->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                            {{ $invoice->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3 col-md-4">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" value="{{ old('supplier_name', $rejectionReturnNote->party->name) }}" readonly>
                                <input type="hidden" name="supplier" id="supplier_id" value="{{ old('supplier', $rejectionReturnNote->party_id) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="supplier_bill_no">Supplier Bill No.</label>
                                <select name="supplier_bill_no" id="supplier_bill_no" class="js-example-basic-single select2" required>
                                    <option value="">Select Bill No.</option>
                                    @php
                                        $seletedIvoiceId = old('invoice', $rejectionReturnNote->invoice_id);
                                    @endphp
                                    @foreach ($goodsReceivings->where('invoice_id', $seletedIvoiceId) as $goodsreceiving)
                                        <option value="{{ $goodsreceiving->supplier_bill_no }}"
                                            {{ old('supplier_bill_no', $rejectionReturnNote->supplier_bill_no) == $goodsreceiving->supplier_bill_no ? 'selected' : '' }}>
                                            {{ $goodsreceiving->supplier_bill_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="store_issue_requisition_id">Store Issue Requisition</label>
                                <select name="store_issue_requisition" id="store_issue_requisition_id" class="js-example-basic-single select2" required onchange="getGeneralStoreRequisitionDetails(this.value)">
                                    <option value="">Select Store Issue Requisition</option>
                                    @php
                                        $seletedCompanyId = old('company', $rejectionReturnNote->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($requisitions->where('company_id', $seletedCompanyId)->where('is_general', '1') as $requisition)
                                        <option value="{{ $requisition->id }}"
                                            {{ old('store_issue_requisition', $rejectionReturnNote->store_issue_requisition_id) == $requisition->id ? 'selected' : '' }}>
                                            {{ $requisition->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @if (count(old('items', $rejectionReturnNote->items)) > 0)
                                        @foreach (old('items', $rejectionReturnNote->items) as $i => $item)
                                            @php
                                                $itemType = $rejectionReturnNote->items[$i]->product_id ? 'product' : 'raw_material_item';
                                            @endphp
                                            <div class="item-set">
                                                <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="card-body px-0 pb-0">
                                                    <input type="hidden" name="items[{{ $i }}][types]" value="{{ old('items.'.$i.'.types', $itemType) }}">
                                                    <div class="row">
                                                        <div class="mb-3 col-md">
                                                            <label for="product_name">Description</label>
                                                            <input type="text" class="form-control" name="items[{{ $i }}][name]"
                                                                   placeholder="Description" required value="{{ old('items.'.$i.'.name', ($itemType == 'product' ? $rejectionReturnNote->items[$i]->product->name : $rejectionReturnNote->items[$i]->rawMaterialItem->name)) }}" readonly>
                                                            <input type="hidden" name="items[{{ $i }}][{{ old('items.'.$i.'.types', $itemType) }}]" 
                                                            value="{{ old('items.'.$i.'.types', $itemType) == 'product' ? old('items.'.$i.'.product', $rejectionReturnNote->items[$i]->product_id) : old('items.'.$i.'.raw_material_item', $rejectionReturnNote->items[$i]->raw_material_item_id) }}">
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Unit Price</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                       placeholder="Unit Price" required value="{{ old("items.$i.unit_price", $rejectionReturnNote->items[$i]->unit_price) }}" readonly>
                                                                <input type="text" class="form-control" name="items[{{ $i }}][unit]"
                                                                       placeholder="Unit" required value="{{ old("items.$i.unit", $rejectionReturnNote->items[$i]->unit) }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Quantity</label>
                                                            <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                                   placeholder="Quantity" required 
                                                                   value="{{ old("items.$i.quantity", $rejectionReturnNote->items[$i]->quantity) }}" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Total</label>
                                                            <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                                   placeholder="Total" required value="{{ old("items.$i.total", $rejectionReturnNote->items[$i]->total) }}" readonly>
                                                        </div>
                                                        <div class="mb-3 col-12">
                                                            <label>Remarks</label>
                                                            <textarea class="form-control" name="items[{{ $i }}][remarks]" placeholder="Write your remarks..." required>{{ old("items.$i.remarks", $rejectionReturnNote->items[$i]->remarks) }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="item-set">
                                            <div class="card-header bg-white py-2 mb-3">
                                                <p class="mb-0 text-center">No data is showing.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <a class="btn btn-secondary" href="{{ route('rejection-return-notes.index') }}">Cancel</a>
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