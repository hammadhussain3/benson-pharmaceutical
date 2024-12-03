@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Invoice</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchase-invoices.index') }}">Invoices</a></li>
                    <li class="breadcrumb-item active">Edit Invoice</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchase-invoices.update', $invoice->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" id="document_type" value="{{ old('type', $invoice->type) }}">
                        <input type="hidden" name="prefix" id="prefix" value="{{ old('prefix', $invoice->prefix) }}">
                        <input type="hidden" name="company" id="company_id" value="{{ old('company', $invoice->company_id) }}">
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="supplier_id">Supplier</label>
                                <select name="party" id="supplier_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Supplier</option>
                                    @php
                                        $seletedCompanyId = old('company', $invoice->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($parties->where('company_id', $seletedCompanyId) as $party)
                                        <option value="{{ $party->id }}"
                                            {{ old('party', $invoice->party_id) == $party->id ? 'selected' : '' }}>
                                            {{ $party->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $invoice->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="required_date">Required Date</label>
                                <input type="date" class="form-control" name="required_date" id="required_date"
                                    placeholder="Required Date" required value="{{ old('required_date', \Carbon\Carbon::parse($invoice->required_date)->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="is_urgent">Is Urgent</label>
                                <select class="js-example-basic-single select2" name="is_urgent" required>
                                    <option value="0" {{ old('is_urgent', $invoice->is_urgent) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_urgent', $invoice->is_urgent) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @php
                                        $oldCount = count(old('invoice_items', []));
                                        $count = $oldCount > 0 ? $oldCount : count($invoice->items);
                                    @endphp
                                    @for ($i = 0; $i < $count; $i++)
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                @if ($i > 0)
                                                    <button type="button" onclick="removeLastItem()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label for="">Raw Material Items</label>
                                                        <select name="invoice_items[{{ $i }}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required>
                                                            <option value="">Select Raw Material</option>
                                                            @php
                                                                $seletedCompanyId = old('company', $invoice->company_id) ?? auth()->user()->employee->company_id;
                                                            @endphp
                                                            @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                <option value="{{ $rawMaterialItem->id }}"
                                                                    {{ old("invoice_items.$i.raw_material_item", $invoice->items[$i]->raw_material_item_id ?? '') == $rawMaterialItem->id ? 'selected' : '' }}>
                                                                    {{ $rawMaterialItem->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="invoice_items[{{ $i }}][unit_price]"
                                                            placeholder="Unit Price" required value="{{ old("invoice_items.$i.unit_price", $invoice->items[$i]->unit_price ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                            <input type="text" class="form-control" name="invoice_items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("invoice_items.$i.unit", $invoice->items[$i]->unit ?? '') }}">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Product Quantity</label>
                                                        <input type="number" class="form-control product_quantity" name="invoice_items[{{ $i }}][quantity]"
                                                            placeholder="Product Quantity" required value="{{ old("invoice_items.$i.quantity", $invoice->items[$i]->quantity ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Tax Rate</label>
                                                        <input type="number" class="form-control tax_rate" name="invoice_items[{{ $i }}][tax_rate]"
                                                            placeholder="Tax Rate" required value="{{ old("invoice_items.$i.tax_rate", $invoice->items[$i]->tax_rate ?? '') }}" oninput="calculatePurchaseInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="status">Discount</label>
                                                        <div class="input-group">
                                                            <select class="form-select" name="invoice_items[{{ $i }}][discount_type]" required>
                                                                <option value="flat" {{ old("invoice_items.$i.discount_type", $invoice->items[$i]->discount_type ?? '') == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                <option value="percent" {{ old("invoice_items.$i.discount_type", $invoice->items[$i]->discount_type ?? '') == 'percent' ? 'selected' : '' }}>Percent</option>
                                                            </select>
                                                            <input type="number" class="form-control w-25 discount" name="invoice_items[{{ $i }}][discount]"
                                                                placeholder="Discount" required value="{{ old("invoice_items.$i.discount", $invoice->items[$i]->discount ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control total_item_amount" name="invoice_items[{{ $i }}][total_amount]"
                                                            placeholder="Total" required value="{{ old("invoice_items.$i.total_amount", $invoice->items[$i]->total_amount ?? 0) }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="mb-3">
                                    <button type="button" onclick="addItem()" class="btn btn-primary">Add Item</button>
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="items_cost_without_tax">Items Cost Without Tax</label>
                                <input type="number" class="form-control" name="items_cost_without_tax" id="items_cost_without_tax"
                                    placeholder="Items Cost Without Tax" required value="{{ old('items_cost_without_tax', $invoice->items_cost_without_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="invoice_tax_rate">Invoice Tax Rate</label>
                                <input type="number" class="form-control" name="invoice_tax_rate" id="invoice_tax_rate"
                                    placeholder="Invoice Tax Rate" required value="{{ old('invoice_tax_rate', $invoice->invoice_tax_rate) }}" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="total_invoice_tax">Total Invoice Tax</label>
                                <input type="number" class="form-control" name="total_invoice_tax" id="total_invoice_tax"
                                    placeholder="Total Invoice Tax" required value="{{ old('total_invoice_tax', $invoice->total_invoice_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="items_cost_with_tax">Items Cost With Tax</label>
                                <input type="number" class="form-control" name="items_cost_with_tax" id="items_cost_with_tax"
                                    placeholder="Items Cost With Tax" required value="{{ old('items_cost_with_tax', $invoice->items_cost_with_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount Type</label>
                                <select class="js-example-basic-single select2" name="discount_type" required id="discount_type">
                                    <option value="flat" {{ old("discount_type",$invoice->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                    <option value="percent" {{ old("discount_type",$invoice->discount_type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount"
                                    placeholder="Discount" required value="{{ old('discount', $invoice->discount) }}" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="returned_amount">Total Amount</label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', $invoice->total_amount) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="note">Special Note</label>
                                <textarea type="text" class="form-control" name="note" id="note"
                                    placeholder="Note" required>{{ old('note', $invoice->note) }}</textarea>
                            </div>
                            
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('purchase-invoices.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const itemSets = document.querySelectorAll('#item-group .item-set');
        let itemIndex = itemSets.length;
        
        function addItem() {
            var html = `
                <div class="item-set">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Item ${itemIndex + 1}</h4><button type="button" onclick="removeLastItem()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="">Raw Material Items</label>
                                <select name="invoice_items[${itemIndex}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="invoice_items[${itemIndex}][unit_price]"
                                        placeholder="Unit Price" required value="" oninput="calculatePurchaseInvoiceAmount()">
                                    <input type="text" class="form-control" name="invoice_items[${itemIndex}][unit]"
                                        placeholder="Unit" required value="">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Product Quantity</label>
                                <input type="number" class="form-control product_quantity" name="invoice_items[${itemIndex}][quantity]"
                                    placeholder="Unit Price" required value="" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Tax Rate</label>
                                <input type="number" class="form-control tax_rate" name="invoice_items[${itemIndex}][tax_rate]"
                                    placeholder="Tax Rate" required value="" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Discount</label>
                                <div class="input-group">
                                    <select class="form-select" name="invoice_items[${itemIndex}][discount_type]" required>
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                    <input type="number" class="form-control w-25 discount" name="invoice_items[${itemIndex}][discount]"
                                        placeholder="Discount" required value="0" oninput="calculatePurchaseInvoiceAmount()">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Total</label>
                                <input type="number" class="form-control total_item_amount" name="invoice_items[${itemIndex}][total_amount]"
                                    placeholder="Total" required value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $("#item-group").append(html);
            // Clone the options from the first dropdown and append to the new dropdown
            const firstDropdownOptions = $(".raw_material_items_dropdown:first").children().clone();
            $(`#item-group .item-set:last .raw_material_items_dropdown`).append(firstDropdownOptions);
            itemIndex++;
            $('.js-example-basic-single').select2({});
        }

        function removeLastItem() {
            // Select all .item-set elements within #item-group
            const itemSets = document.querySelectorAll('#item-group .item-set');
            
            // Only remove if there is more than one item set
            if (itemSets.length > 1) {
                itemSets[itemSets.length - 1].remove(); // Remove the last added item set
                calculatePurchaseInvoiceAmount();
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
    </script>
@endsection