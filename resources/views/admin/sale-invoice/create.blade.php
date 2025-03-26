@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Sale Invoice</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale-invoices.index') }}">Sale Invoices</a></li>
                    <li class="breadcrumb-item active">Add Sale Invoice</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sale-invoices.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="type" id="document_type" value="{{ old('type', 'sale') }}">
                        <input type="hidden" name="prefix" id="prefix" value="{{ old('prefix', 'SI') }}">
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectProductVariationsByCompany(this.value); selectFranchisers(this.value); createSaleInvoiceCode(this.value);">
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
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $newInvoiceCode) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="franchiser_id">Franchisers</label>
                                <select name="party" id="franchiser_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Franchiser</option>
                                    @if(old('party') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($parties->where('company_id', $seletedCompanyId)->where('is_distributor', '1') as $party)
                                            <option value="{{ $party->id }}"
                                                {{ old('party') == $party->id ? 'selected' : '' }}>
                                                {{ $party->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="order_number">Order Number</label>
                                <input type="text" class="form-control" name="order_number" id="order_number"
                                    placeholder="Order Number" required value="{{ old('order_number') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="order_date">Order Date</label>
                                <input type="date" class="form-control" name="order_date" id="order_date"
                                    placeholder="Order Date" required value="{{ old('order_date') }}" max="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="shipped_via">Shipped Via</label>
                                <input type="text" class="form-control" name="shipped_via" id="shipped_via"
                                    placeholder="Shipped Via" required value="{{ old('shipped_via') }}">
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @php
                                        $count = max(
                                            count(old('invoice_items', [])),
                                            1
                                        );
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
                                                    <div class="mb-3 col-md-6">
                                                        <label for="">Products</label>
                                                        <select name="invoice_items[{{ $i }}][product]" class="js-example-basic-single select2 product_variations_dropdown" 
                                                            onchange="selectBatchesByProductVariation(this.value, this)" required>
                                                            <option value="">Select Products</option>
                                                            @if(old('invoice_items[{{ $i }}][product]') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                                                @php
                                                                    $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                @foreach ($productVariations->where('company_id', $seletedCompanyId) as $productVariation)
                                                                    <option value="{{ $productVariation->id }}"
                                                                        {{ old("invoice_items.$i.product") == $productVariation->id ? 'selected' : '' }}>
                                                                        {{ $productVariation->product->name. ' | ' .$productVariation->packingType->name. ' | ' .$productVariation->packSize->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="">Batches</label>
                                                        <select name="invoice_items[{{ $i }}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                                            <option value="">Select Batch</option>
                                                            @if(old('invoice_items[{{ $i }}][batch]') || old('invoice_items[{{ $i }}][product]') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                                                @php
                                                                    $selectedProductVariationId = old("invoice_items.$i.product");
                                                                    $productVariation = $productVariations->find($selectedProductVariationId);
                                                                    $productId = $productVariation->product_id ?? null;
                                                                @endphp
                                                                @foreach ($batches->where('product_id', $productId)->where('company_id', $seletedCompanyId) as $batch)
                                                                    <option value="{{ $batch->id }}"
                                                                        {{ old("invoice_items.$i.batch") == $batch->id ? 'selected' : '' }}>
                                                                        {{ $batch->batch_no }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="invoice_items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("invoice_items.$i.unit_price") }}" oninput="calculateSaleInvoiceAmount()">
                                                            <input type="text" class="form-control" name="invoice_items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("invoice_items.$i.unit") }}">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Pack Quantity</label>
                                                        <input type="number" class="form-control product_quantity" name="invoice_items[{{ $i }}][quantity]"
                                                            placeholder="Pack Quantity" required value="{{ old("invoice_items.$i.quantity") }}" oninput="calculateSaleInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Tax Rate</label>
                                                        <input type="number" class="form-control tax_rate" name="invoice_items[{{ $i }}][tax_rate]"
                                                            placeholder="Tax Rate" required value="{{ old("invoice_items.$i.tax_rate") }}" oninput="calculateSaleInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="status">Discount</label>
                                                        <div class="input-group">
                                                            <select class="form-select" name="invoice_items[{{ $i }}][discount_type]" required>
                                                                <option value="flat" {{ old("invoice_items.$i.discount_type") == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                <option value="percent" {{ old("invoice_items.$i.discount_type") == 'percent' ? 'selected' : '' }}>Percent</option>
                                                            </select>
                                                            <input type="number" class="form-control w-25 discount" name="invoice_items[{{ $i }}][discount]"
                                                                placeholder="Discount" required value="{{ old("invoice_items.$i.discount", 0) }}" oninput="calculateSaleInvoiceAmount()">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Trans. Code</label>
                                                        <input type="number" class="form-control" name="invoice_items[{{ $i }}][trans_code]"
                                                            placeholder="Trans. Code" value="{{ old("invoice_items.$i.trans_code") }}">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control total_item_amount" name="invoice_items[{{ $i }}][total_amount]"
                                                            placeholder="Total" required value="{{ old("invoice_items.$i.total_amount", 0) }}" readonly>
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
                            <div class="mb-3 col-md-4">
                                <label for="returned_amount">Payment Deadline</label>
                                <input type="date" class="form-control" name="payment_deadline" id="payment_deadline"
                                    placeholder="Payment Deadline" required value="{{ old('payment_deadline') }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="shipping_cost">Shipping Cost</label>
                                <input type="number" class="form-control" name="shipping_cost" id="shipping_cost"
                                    placeholder="Shipping Cost" required value="{{ old('shipping_cost', 0) }}" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_without_tax">Items Cost Without Tax</label>
                                <input type="number" class="form-control" name="items_cost_without_tax" id="items_cost_without_tax"
                                    placeholder="Items Cost Without Tax" required value="{{ old('items_cost_without_tax', 0) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="invoice_tax_rate">Invoice Tax Rate</label>
                                <input type="number" class="form-control" name="invoice_tax_rate" id="invoice_tax_rate"
                                    placeholder="Invoice Tax Rate" required value="{{ old('invoice_tax_rate') }}" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="total_invoice_tax">Total Invoice Tax</label>
                                <input type="number" class="form-control" name="total_invoice_tax" id="total_invoice_tax"
                                    placeholder="Total Invoice Tax" required value="{{ old('total_invoice_tax', 0) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Items Cost With Tax</label>
                                <input type="number" class="form-control" name="items_cost_with_tax" id="items_cost_with_tax"
                                    placeholder="Items Cost With Tax" required value="{{ old('items_cost_with_tax', 0) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount Type</label>
                                <select class="js-example-basic-single select2" name="discount_type" required id="discount_type">
                                    <option value="flat" {{ old("discount_type") == 'flat' ? 'selected' : '' }}>Flat</option>
                                    <option value="percent" {{ old("discount_type") == 'percent' ? 'selected' : '' }}>Percent</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount"
                                    placeholder="Discount" required value="{{ old('discount', 0) }}" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="returned_amount">Total Amount</label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', 0) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="paid_amount">Paid Amount</label>
                                <input type="number" class="form-control" name="paid_amount" id="paid_amount"
                                    placeholder="Paid Amount" required value="{{ old('paid_amount', 0) }}" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="returned_amount">Returned Amount</label>
                                <input type="number" class="form-control" name="returned_amount" id="returned_amount"
                                    placeholder="Returned Amount" required value="{{ old('returned_amount', 0) }}" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="due_amount">Due Amount</label>
                                <input type="number" class="form-control" name="due_amount" id="due_amount"
                                    placeholder="Due Amount" required value="{{ old('due_amount', 0) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="note">Special Note</label>
                                <textarea type="text" class="form-control" name="note" id="note"
                                    placeholder="Note" required>{{ old('note') }}</textarea>
                            </div>
                        </div>
                        <a class="btn btn-secondary" href="{{ route('sale-invoices.index') }}">Cancel</a>
                        <!-- Hidden input for is_approved -->
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
                            <div class="mb-3 col-md-6">
                                <label for="">Products</label>
                                <select name="invoice_items[${itemIndex}][product]" class="js-example-basic-single select2 product_variations_dropdown" onchange="selectBatchesByProductVariation(this.value, this)" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="">Batches</label>
                                <select name="invoice_items[${itemIndex}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                    <option value="">Select Batch</option>
                                </select>
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="invoice_items[${itemIndex}][unit_price]"
                                        placeholder="Unit Price" required value="" oninput="calculateSaleInvoiceAmount()">
                                    <input type="text" class="form-control" name="invoice_items[${itemIndex}][unit]"
                                        placeholder="Unit" required value="">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Pack Quantity</label>
                                <input type="number" class="form-control product_quantity" name="invoice_items[${itemIndex}][quantity]"
                                    placeholder="Pack Quantity" required value="" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Tax Rate</label>
                                <input type="number" class="form-control tax_rate" name="invoice_items[${itemIndex}][tax_rate]"
                                    placeholder="Tax Rate" required value="" oninput="calculateSaleInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Discount</label>
                                <div class="input-group">
                                    <select class="form-select" name="invoice_items[${itemIndex}][discount_type]" required>
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                    <input type="number" class="form-control w-25 discount" name="invoice_items[${itemIndex}][discount]"
                                        placeholder="Discount" required value="0" oninput="calculateSaleInvoiceAmount()">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Trans. Code</label>
                                <input type="number" class="form-control" name="invoice_items[${itemIndex}][trans_code]" placeholder="Trans. Code">
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
            const firstDropdownOptions = $(".product_variations_dropdown:first").children().clone();
            $(`#item-group .item-set:last .product_variations_dropdown`).append(firstDropdownOptions);
            itemIndex++;
            $('.js-example-basic-single').select2({});
        }

        function removeLastItem() {
            // Select all .item-set elements within #item-group
            const itemSets = document.querySelectorAll('#item-group .item-set');
            
            // Only remove if there is more than one item set
            if (itemSets.length > 1) {
                itemSets[itemSets.length - 1].remove(); // Remove the last added item set
                calculateSaleInvoiceAmount();
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
    </script>
@endsection