@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Goods Receiving Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('goods-receivings.index') }}">Goods Receiving Notes</a></li>
                    <li class="breadcrumb-item active">Edit Goods Receiving Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('goods-receivings.update', $goodsReceiving->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectInvoices(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $goodsReceiving->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $goodsReceiving->code) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="invoice_id">Invoice</label>
                                <select name="invoice" id="invoice_id" class="js-example-basic-single select2" required  onchange="getInvoiceDetails(this.value);">
                                    <option value="">Select Invoice</option>
                                    @php
                                        $seletedCompanyId = old('company', $goodsReceiving->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($invoices->where('company_id', $seletedCompanyId) as $invoice)
                                        <option value="{{ $invoice->id }}"
                                            {{ old('invoice', $goodsReceiving->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                            {{ $invoice->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" value="{{ old('supplier_name', $goodsReceiving->party->name) }}" readonly>
                                <input type="hidden" name="supplier" id="supplier_id" value="{{ old('supplier', $goodsReceiving->party_id) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="generic_name">Supplier Code</label>
                                <input type="text" class="form-control" name="supplier_code" id="supplier_code"
                                    placeholder="Supplier Code" required value="{{ old('supplier_code', $goodsReceiving->party->code) }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @if (count(old('items', $goodsReceiving->items)) > 0)
                                    @for ($i = 0; $i < count(old('items', $goodsReceiving->items)); $i++)
                                        @php
                                            $itemType = $goodsReceiving->items[$i]->product_id ? 'product' : 'raw_material_item';
                                        @endphp
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <input type="hidden" name="items[{{ $i }}][types]" value="{{ old('items.'.$i.'.types', $itemType) }}">
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label for="product_code">Code</label>
                                                        <input type="text" class="form-control" name="items[{{ $i }}][code]"
                                                            placeholder="Product Code" required value="{{ old('items.'.$i.'.code', $goodsReceiving->items[$i]->item->code) }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="product_name">Description</label>
                                                        <input type="text" class="form-control" name="items[{{ $i }}][name]"
                                                            placeholder="Product Name" required value="{{ old('items.'.$i.'.name', $goodsReceiving->items[$i]->item->name) }}" readonly>
                                                            <input type="hidden" 
                                                                name="items[{{ $i }}][{{ old('items.'.$i.'.types', $itemType) }}]" 
                                                                value="{{ old('items.'.$i.'.types', $itemType) == 'product' ? old('items.'.$i.'.product', $goodsReceiving->items[$i]->product_id) : old('items.'.$i.'.raw_material_item', $goodsReceiving->items[$i]->raw_material_item_id) }}">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="batch_id">Batch</label>
                                                        <select name="items[{{ $i }}][batch]" id="batch_id_{{ $i }}" class="js-example-basic-single select2" required>
                                                            <option value="">Select Batch</option>
                                                            @if ($goodsReceiving->items[$i]->product_id)
                                                                @php
                                                                    $seletedCompanyId = old('company', $goodsReceiving->company_id) ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                @foreach ($batches->where('company_id', $seletedCompanyId)->where('product_id', old('items.'.$i.'.product', $goodsReceiving->items[$i]->product_id)) as $batch)
                                                                    <option value="{{ $batch->id }}"
                                                                        {{ old('items.'.$i.'.batch', $goodsReceiving->items[$i]->batch_id) == $batch->id ? 'selected' : '' }}>
                                                                        {{ $batch->batch_no }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity Ordered</label>
                                                        <input type="number" class="form-control" name="items[{{ $i }}][quantity_ordered]"
                                                            placeholder="Quantity Ordered" required value="{{ old('items.'.$i.'.quantity_ordered', $goodsReceiving->items[$i]->quantity_ordered) }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity Received</label>
                                                        <input type="number" class="form-control" name="items[{{ $i }}][quantity_received]"
                                                            placeholder="Quantity Received" required value="{{ old('items.'.$i.'.quantity_received', $goodsReceiving->items[$i]->quantity_received) }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Balance Receivable</label>
                                                        <input type="number" class="form-control balance_receivable" name="items[{{ $i }}][balance_receivable]"
                                                            placeholder="Balance Receivable" required value="{{ old('items.'.$i.'.balance_receivable', $goodsReceiving->items[$i]->balance_receivable) }}" oninput="calculateGoodsRecievingAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit</label>
                                                        <input type="text" class="form-control" name="items[{{ $i }}][unit]" placeholder="Unit" required value="{{ old('items.'.$i.'.unit', $goodsReceiving->items[$i]->unit) }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <input type="text" class="form-control unit_price" name="items[{{ $i }}][unit_price]"
                                                            placeholder="Unit Price" required value="{{ old('items.'.$i.'.unit_price', $goodsReceiving->items[$i]->unit_price) }}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control product_total" name="items[{{ $i }}][total_amount]"
                                                            placeholder="Total" required value="{{ old('items.'.$i.'.total_amount', $goodsReceiving->items[$i]->total_amount) }}" readonly>
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
                                <label for="supplier_bill_no">Supplier Bill No</label>
                                <input type="text" class="form-control" name="supplier_bill_no" id="supplier_bill_no"
                                    placeholder="Supplier Bill No" required value="{{ old('supplier_bill_no', $goodsReceiving->supplier_bill_no) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="therapeutic_class">Sales Tax</label>
                                <input type="number" class="form-control" name="sales_tax" id="sales_tax"
                                    placeholder="Sales Tax" required value="{{ old('sales_tax', $goodsReceiving->sales_tax) }}" oninput="calculateGoodsRecievingAmount()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="adv_tax">Adv Tax</label>
                                <input type="number" class="form-control" name="adv_tax" id="adv_tax"
                                    placeholder="Advance Tax" required value="{{ old('adv_tax', $goodsReceiving->adv_tax) }}" oninput="calculateGoodsRecievingAmount()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', $goodsReceiving->total_amount) }}" readonly>
                            </div>
                            @if(auth()->user()->hasPermission('Document Approval Edit'))
                                <div class="mb-3 col-md-6">
                                    <label for="is_approved">Is Approved</label>
                                    <select name="is_approved" id="is_approved" class="form-control" required>
                                        <option value="1" {{ old('is_approved', $goodsReceiving->is_approved) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_approved', $goodsReceiving->is_approved) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('goods-receivings.index') }}">Cancel</a>
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