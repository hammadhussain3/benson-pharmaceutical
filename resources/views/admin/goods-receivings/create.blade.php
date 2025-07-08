@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Goods Receiving Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('goods-receivings.index') }}">Goods Receiving Notes</a></li>
                    <li class="breadcrumb-item active">Add Goods Receiving Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('goods-receivings.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectInvoices(this.value); createGoodsReceivingsCode(this.value);" @endrole>
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
                            <div class="mb-3 col-md-6">
                                <label for="code">Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $newGoodsReceivingCode) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="invoice_id">PO<span class="text-danger">*</span></label>
                                <select name="invoice" id="invoice_id" class="js-example-basic-single select2" required  onchange="getInvoiceDetails(this.value);">
                                    <option value="">Select PO</option>
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
                            
                            <div class="mb-3 col-md-6">
                                <label for="supplier">Supplier<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" value="{{ old('supplier_name') }}" readonly>
                                <input type="hidden" name="supplier" id="supplier_id" value="{{ old('supplier') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="generic_name">Supplier Code</label>
                                <input type="text" class="form-control" name="supplier_code" id="supplier_code"
                                    placeholder="Supplier Code" required value="{{ old('supplier_code') }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @if (count(old('items', [])) > 0)
                                    @for ($i = 0; $i < count(old('items', [])); $i++)
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <input type="hidden" name="items[{{ $i }}][types]" value="{{ old('items.'.$i.'.types') }}">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="product_name">Description</label>
                                                        <textarea name="items[{{ $i }}][description]" class="form-control" readonly>{{ old('items.'.$i.'.description') }}</textarea>
                                                        <input type="hidden" 
                                                            name="items[{{ $i }}][{{ old('items.'.$i.'.types') == 'product' ? 'product' : 'raw_material_item' }}]" 
                                                            value="{{ old('items.'.$i.'.types') == 'product' ? old('items.'.$i.'.product') : old('items.'.$i.'.raw_material_item') }}">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="product_code">Code<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="items[{{ $i }}][code]"
                                                            placeholder="Product Code" required value="{{ old('items.'.$i.'.code') }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity Ordered</label>
                                                        <input type="number" class="form-control" name="items[{{ $i }}][quantity_ordered]"
                                                            placeholder="Quantity Ordered" required value="{{ old('items.'.$i.'.quantity_ordered') }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity Received</label>
                                                        <input type="number" class="form-control" name="items[{{ $i }}][quantity_received]"
                                                            placeholder="Quantity Received" required value="{{ old('items.'.$i.'.quantity_received') }}" readonly>
                                                    </div>
                                                    <div class="col-12 grn-rows-container" data-index="{{ $i }}">
                                                        @php $grnItems = old("items.$i.grn_items", []); @endphp
                                                        @for ($j = 0; $j < count($grnItems); $j++)
                                                            <div class="row grn-row align-items-end">
                                                                <div class="mb-3 col-md-auto {{ $j === 0 ? 'd-none' : ''}}">
                                                                    <button type="button" class="btn btn-danger remove-grn-row"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                                <div class="mb-3 col-md">
                                                                    <label>Batch#<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="items[{{ $i }}][grn_items][{{ $j }}][batch]" value="{{ old('items.'.$i.'.grn_items.'.$j.'.batch') }}" placeholder="Enter Batch#">
                                                                </div>
                                                                <div class="mb-3 col-md">
                                                                    <label>Quantity Receiving<span class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control balance_receivable" name="items[{{ $i }}][grn_items][{{ $j }}][balance_receivable]" value="{{ old('items.'.$i.'.grn_items.'.$j.'.balance_receivable') }}" placeholder="Balance Receivable" oninput="calculateGoodsRecievingAmount()">
                                                                </div>
                                                                <div class="mb-3 col-md">
                                                                    <label>Unit Price</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control w-50 unit_price" name="items[{{ $i }}][grn_items][{{ $j }}][unit_price]" value="{{ old('items.'.$i.'.grn_items.'.$j.'.unit_price') }}" readonly>
                                                                        <input type="text" class="form-control" name="items[{{ $i }}][grn_items][{{ $j }}][unit]" value="{{ old('items.'.$i.'.grn_items.'.$j.'.unit') }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 col-md">
                                                                    <label>Total</label>
                                                                    <input type="number" class="form-control product_total" name="items[{{ $i }}][grn_items][{{ $j }}][total_amount]"
                                                                        placeholder="Total" required value="{{ old('items.'.$i.'.grn_items.'.$j.'.total_amount', 0) }}" readonly>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                    <div class="mb-3 col-md-auto ms-auto d-flex align-items-end">
                                                        <button type="button" class="btn btn-secondary add-grn-row" data-index="{{ $i }}"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                    @else
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2">
                                                <p class="mb-0 text-center">No data is showing.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="supplier_bill_no">Supplier Bill No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="supplier_bill_no" id="supplier_bill_no"
                                    placeholder="Supplier Bill No" required value="{{ old('supplier_bill_no') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="therapeutic_class">Sales Tax<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="sales_tax" id="sales_tax"
                                    placeholder="Sales Tax" required value="{{ old('sales_tax', 0) }}" oninput="calculateGoodsRecievingAmount()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="adv_tax">Adv Tax<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="adv_tax" id="adv_tax"
                                    placeholder="Advance Tax" required value="{{ old('adv_tax', 0) }}" oninput="calculateGoodsRecievingAmount()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', 0) }}" readonly>
                            </div>
                        </div>
                        <a class="btn btn-secondary" href="{{ route('goods-receivings.index') }}">Cancel</a>
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
        document.addEventListener('click', function (e) {
            // Handle Add GRN Row
            if (e.target.closest('.add-grn-row')) {
                const btn = e.target.closest('.add-grn-row');

                // Find nearest grn-rows-container above the button
                const grnContainer = btn.closest('.item-set')?.querySelector('.grn-rows-container');
                if (!grnContainer) return;

                const rows = grnContainer.querySelectorAll('.grn-row');
                const lastIndex = rows.length;
                const index = grnContainer.dataset.index;

                const firstRow = rows[0];
                const clone = firstRow.cloneNode(true);

                // Update name attributes and reset values
                clone.querySelectorAll('input').forEach(input => {
                    const name = input.name;
                    if (!name) return;

                    const newName = name.replace(/\[grn_items]\[\d+]/, `[grn_items][${lastIndex}]`);
                    input.name = newName;

                    if (name.includes('[unit_price]') || name.includes('[unit]')) {
                        // keep value
                    } else {
                        input.value = '';
                    }
                });

                // Show trash icon
                const removeCol = clone.querySelector('.remove-grn-row')?.closest('.col-md-auto');
                if (removeCol) removeCol.classList.remove('d-none');

                grnContainer.appendChild(clone);
            }

            // Handle Remove GRN Row
            if (e.target.closest('.remove-grn-row')) {
                e.preventDefault();
                const row = e.target.closest('.grn-row');
                if (row) row.remove();
                calculateGoodsRecievingAmount();
            }
        });
</script>
@endsection