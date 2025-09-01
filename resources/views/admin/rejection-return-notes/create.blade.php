@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Rejection Return Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rejection-return-notes.index') }}">Rejection Return Notes</a></li>
                    <li class="breadcrumb-item active">Add Rejection Return Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rejection-return-notes.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectInvoices(this.value); selectGeneralStoreRequisitions(this.value); createRejectionCode(this.value)" @endrole>
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
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $newRejectionCode) }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="invoice_id">Invoice</label>
                                <select name="invoice" id="invoice_id" class="js-example-basic-single select2" required onchange="selectSupplierByInvoice(this.value); selectSupplierBillNoByInvoice(this.value);">
                                    <option value="">Select Invoice</option>
                                    @if(old('invoice') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($invoices->where('company_id', $seletedCompanyId) as $invoice)
                                            <option value="{{ $invoice->id }}"
                                                {{ old('invoice') == $invoice->id ? 'selected' : '' }}>
                                                {{ $invoice->code }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="mb-3 col-md-4">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" value="{{ old('supplier_name') }}" readonly>
                                <input type="hidden" name="supplier" id="supplier_id" value="{{ old('supplier') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="supplier_bill_no">Supplier Bill No.</label>
                                <select name="supplier_bill_no" id="supplier_bill_no" class="js-example-basic-single select2" required>
                                    <option value="">Select Bill No.</option>
                                    @if(old('supplier_bill_no') || old('invoice'))
                                        @php
                                            $seletedIvoiceId = old('invoice');
                                        @endphp
                                        @foreach ($goodsReceivings->where('invoice_id', $seletedIvoiceId) as $goodsreceiving)
                                            <option value="{{ $goodsreceiving->supplier_bill_no }}"
                                                {{ old('supplier_bill_no') == $goodsreceiving->supplier_bill_no ? 'selected' : '' }}>
                                                {{ $goodsreceiving->supplier_bill_no }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="store_issue_requisition_id">Store Issue Requisition</label>
                                <select name="store_issue_requisition" id="store_issue_requisition_id" class="js-example-basic-single select2" required onchange="getGeneralStoreRequisitionDetails(this.value)">
                                    <option value="">Select Store Issue Requisition</option>
                                    @if(old('store_issue_requisition') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($requisitions->where('company_id', $seletedCompanyId)->where('is_general', '1') as $requisition)
                                            <option value="{{ $requisition->id }}"
                                                {{ old('store_issue_requisition') == $requisition->id ? 'selected' : '' }}>
                                                {{ $requisition->code }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @if (count(old('items', [])) > 0)
                                        @foreach (old('items', []) as $i => $item)
                                            <div class="item-set">
                                                <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="card-body px-0 pb-0">
                                                    <input type="hidden" name="items[{{ $i }}][types]" 
                                                           value="{{ isset($item['product']) ? 'product' : 'raw_material_item' }}">
                                                    <div class="row">
                                                        <div class="mb-3 col-md">
                                                            <label for="product_name">Description</label>
                                                            <input type="text" class="form-control" name="items[{{ $i }}][name]"
                                                                   placeholder="Description" required value="{{ old('items.'.$i.'.name') }}" readonly>
                                                            <input type="hidden" name="items[{{ $i }}][{{ old('items.'.$i.'.types') == 'product' ? 'product' : 'raw_material_item' }}]" 
                                                                value="{{ old('items.'.$i.'.types') == 'product' ? old('items.'.$i.'.product') : old('items.'.$i.'.raw_material_item') }}">
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Unit Price</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                       placeholder="Unit Price" required value="{{ old("items.$i.unit_price", 0) }}" readonly>
                                                                <input type="text" class="form-control" name="items[{{ $i }}][unit]"
                                                                       placeholder="Unit" required value="{{ old("items.$i.unit") }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Quantity</label>
                                                            <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                                   placeholder="Quantity" required 
                                                                   value="{{ old("items.$i.quantity", 0) }}" 
                                                                   max="{{ old("items.$i.max_quantity") }}"
                                                                   min="1" oninput="calculateSingleProductAmount()">
                                                            <input type="hidden" name="items[{{ $i }}][max_quantity]" value="{{ old("items.$i.max_quantity") }}">
                                                        </div>
                                                        <div class="mb-3 col-md">
                                                            <label>Total</label>
                                                            <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                                   placeholder="Total" required value="{{ old("items.$i.total", 0) }}" readonly>
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