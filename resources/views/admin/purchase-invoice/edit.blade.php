@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Purchase Order</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchase-invoices.index') }}">Purchase Orders</a></li>
                    <li class="breadcrumb-item active">Edit Purchase Order</li>
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
                                <label for="supplier_id">Supplier<span class="text-danger">*</span></label>
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
                            <div class="mb-3 col-md-3">
                                <label for="code">Doc. No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $invoice->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="required_date">Required Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="required_date" id="required_date"
                                    placeholder="Required Date" required value="{{ old('required_date', \Carbon\Carbon::parse($invoice->required_date)->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="payment_deadline">Payment Deadline</label>
                                <input type="date" class="form-control" name="payment_deadline" id="payment_deadline"
                                    placeholder="Payment Deadline" required value="{{ old('payment_deadline', 0) }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_urgent">Is Urgent<span class="text-danger">*</span></label>
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
                                                        <label for="">Code</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][code]" value="{{ old("invoice_items.$i.code", $invoice->items[$i]->code) }}" class="form-control code" placeholder="Code" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="">Raw Material Items<span class="text-danger">*</span></label>
                                                        <select name="invoice_items[{{ $i }}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required onchange="selectLastPurchaseRmi(this.value, this); selectRmiDetailsT(this.value, this); updateRmiTitle(this);">
                                                            <option value="">Select Raw Material</option>
                                                            @php
                                                                $seletedCompanyId = old('company', $invoice->company_id) ?? auth()->user()->employee->company_id;
                                                            @endphp
                                                            @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                <option value="{{ $rawMaterialItem->id }}"
                                                                    {{ old("invoice_items.$i.raw_material_item", $invoice->items[$i]->raw_material_item_id ?? '') == $rawMaterialItem->id ? 'selected' : '' }}>
                                                                    {{ $invoice->items[$i]->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" class="rmi_title" name="invoice_items[{{ $i }}][title]" value="{{ old('invoice_items.$i.title', $invoice->items[$i]->title) }}">
                                                    </div>
                                                    @php
                                                        $invoice->items[$i]->last_purchase = App\Models\InvoiceItem::getLastPurchaseByRawMaterial($invoice->items[$i]->raw_material_item_id, $invoice->items[$i]->id);
                                                    @endphp
                                                    <div class="mb-3 col-md-4">
                                                        <label for="">Current Balance</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][balance]" value="{{ old("invoice_items.$i.balance", $invoice->items[$i]->balance) }}" class="form-control balance" placeholder="Balance" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label>Description</label>
                                                        <textarea name="invoice_items[{{ $i }}][description]" class="form-control description" readonly>{{ old("invoice_items.$i.description", $invoice->items[$i]->description) }}</textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="">Min. Level</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][min_level]" value="{{ old("invoice_items.$i.min_level", $invoice->items[$i]->min_level) }}" class="form-control min_level" placeholder="Min. level" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="">Max. Level</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][max_level]" value="{{ old("invoice_items.$i.max_level", $invoice->items[$i]->max_level) }}" class="form-control max_level" placeholder="Max. level" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label>Quantity Required<span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control product_quantity" name="invoice_items[{{ $i }}][quantity]"
                                                            placeholder="Product Quantity" required value="{{ old("invoice_items.$i.quantity", $invoice->items[$i]->quantity ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="invoice_items[{{ $i }}][unit_price]"
                                                            placeholder="Unit Price" required value="{{ old("invoice_items.$i.unit_price", $invoice->items[$i]->unit_price ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                            <input type="text" class="form-control unit" name="invoice_items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("invoice_items.$i.unit", $invoice->items[$i]->unit ?? '') }}" readonly>
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label>Last Purchase</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control lp_ref" name="invoice_items[{{ $i }}][lp_ref]"
                                                                placeholder="Ref." required value="{{ old("invoice_items.$i.lp_ref", $invoice->items[$i]->lp_ref) }}" readonly>
                                                            <input type="text" class="form-control lp_price" name="invoice_items[{{ $i }}][lp_price]"
                                                                placeholder="Supplier" required value="{{ old("invoice_items.$i.lp_price", $invoice->items[$i]->lp_price) }}" readonly>
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label>In Process</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control w-25 ip_po_list" name="invoice_items[{{ $i }}][ip_po_list]"
                                                                placeholder="PO list" required value="{{ old("invoice_items.$i.ip_po_list", $invoice->items[$i]->ip_po_list) }}" readonly>
                                                            <input type="text" class="form-control ip_quantity" name="invoice_items[{{ $i }}][ip_quantity]"
                                                                placeholder="Qty" required value="{{ old("invoice_items.$i.ip_quantity", $invoice->items[$i]->ip_quantity) }}" readonly>
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label for="">Consumption 6 Month</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][consumption_6_month]" value="{{ old("invoice_items.$i.consumption_6_month", $invoice->items[$i]->consumption_6_month) }}" class="form-control consumption_6_month" placeholder="Consumption 6 month" readonly>
                                                    </div>
                                                    {{-- <div class="mb-3 col-md-3">
                                                        <label>Tax Rate</label>
                                                        <input type="number" class="form-control tax_rate" name="invoice_items[{{ $i }}][tax_rate]"
                                                            placeholder="Tax Rate" required value="{{ old("invoice_items.$i.tax_rate", $invoice->items[$i]->tax_rate ?? '') }}" oninput="calculatePurchaseInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label for="status">Discount</label>
                                                        <div class="input-group">
                                                            <select class="form-select" name="invoice_items[{{ $i }}][discount_type]" required>
                                                                <option value="flat" {{ old("invoice_items.$i.discount_type", $invoice->items[$i]->discount_type ?? '') == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                <option value="percent" {{ old("invoice_items.$i.discount_type", $invoice->items[$i]->discount_type ?? '') == 'percent' ? 'selected' : '' }}>Percent</option>
                                                            </select>
                                                            <input type="number" class="form-control w-25 discount" name="invoice_items[{{ $i }}][discount]"
                                                                placeholder="Discount" required value="{{ old("invoice_items.$i.discount", $invoice->items[$i]->discount ?? 0) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                          </div>
                                                    </div> --}}
                                                    <div class="mb-3 col-md-3">
                                                        <label>Total<span class="text-danger">*</span></label>
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
                            {{-- <div class="mb-3 col-md-2">
                                <label for="items_cost_without_tax">Items Cost Without Tax</label>
                                <input type="number" class="form-control" name="items_cost_without_tax" id="items_cost_without_tax"
                                    placeholder="Items Cost Without Tax" required value="{{ old('items_cost_without_tax', $invoice->items_cost_without_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="invoice_tax_rate">Tax Rate</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="invoice_tax_rate" id="invoice_tax_rate"
                                        placeholder="Tax" required value="{{ old('invoice_tax_rate', $invoice->invoice_tax_rate) }}" oninput="calculatePurchaseInvoiceAmount()">
                                    <input type="number" class="form-control" name="total_invoice_tax" id="total_invoice_tax"
                                        placeholder="Total Invoice Tax" required value="{{ old('total_invoice_tax', $invoice->total_invoice_tax) }}" readonly>
                                </div>
                                
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="items_cost_with_tax">Items Cost With Tax</label>
                                <input type="number" class="form-control" name="items_cost_with_tax" id="items_cost_with_tax"
                                    placeholder="Items Cost With Tax" required value="{{ old('items_cost_with_tax', $invoice->items_cost_with_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="items_cost_with_tax">Discount</label>
                                <div class="input-group">
                                    <select class="form-select" name="discount_type" required id="discount_type">
                                        <option value="flat" {{ old("discount_type",$invoice->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                        <option value="percent" {{ old("discount_type",$invoice->discount_type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                    </select>
                                    <input type="number" class="form-control w-25" name="discount" id="discount"
                                        placeholder="Discount" required value="{{ old('discount', $invoice->discount) }}" oninput="calculatePurchaseInvoiceAmount()">
                                </div>
                            </div> --}}
                            <div class="mb-3 col-md-3">
                                <label for="returned_amount">Total Amount<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', $invoice->total_amount) }}" readonly>
                            </div>
                            {{-- <div class="mb-3 col-md-3">
                                <label for="paid_amount">Paid Amount</label>
                                <input type="number" class="form-control" name="paid_amount" id="paid_amount"
                                    placeholder="Paid Amount" required value="{{ old('paid_amount', $invoice->paid_amount) }}" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="returned_amount">Returned Amount</label>
                                <input type="number" class="form-control" name="returned_amount" id="returned_amount"
                                    placeholder="Returned Amount" required value="{{ old('returned_amount', $invoice->returned_amount) }}" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="due_amount">Due Amount</label>
                                <input type="number" class="form-control" name="due_amount" id="due_amount"
                                    placeholder="Due Amount" required value="{{ old('due_amount', $invoice->due_amount) }}" readonly>
                            </div> --}}
                            <div class="mb-3 col-md-12">
                                <label for="note">Special Note</label>
                                <textarea type="text" class="form-control" name="note" id="note"
                                    placeholder="Note" required>{{ old('note', $invoice->note) }}</textarea>
                            </div>
                            {{-- <div class="mb-3 col-md-6">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ old('status', $invoice->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $invoice->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="partial" {{ old('status', $invoice->status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                </select>
                            </div> --}}
                        </div>
                        <a class="btn btn-secondary" href="{{ route('purchase-invoices.index') }}">Cancel</a>
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
                            <div class="mb-3 col-md-4">
                                <label>Code</label>
                                <input type="text" class="form-control code" name="invoice_items[${itemIndex}][code]"
                                    placeholder="Code" readonly value="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="">Raw Material Items<span class="text-danger">*</span></label>
                                <select name="invoice_items[${itemIndex}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required onchange="selectLastPurchaseRmi(this.value, this); selectRmiDetailsT(this.value, this); updateRmiTitle(this);">
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Current Balance</label>
                                <input type="text" class="form-control balance" name="invoice_items[${itemIndex}][balance]"
                                    placeholder="Balance" value="" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label>Description</label>
                                <textarea class="form-control description" name="invoice_items[${itemIndex}][description]" readonly></textarea>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Min. Level</label>
                                <input type="text" class="form-control min_level" name="invoice_items[${itemIndex}][min_level]"
                                    placeholder="Min. Level" value="" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Max. Level</label>
                                <input type="text" class="form-control max_level" name="invoice_items[${itemIndex}][max_level]"
                                    placeholder="Max. Level" value="" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Quantity Required<span class="text-danger">*</span></label>
                                <input type="number" class="form-control product_quantity" name="invoice_items[${itemIndex}][quantity]"
                                    placeholder="Quantity" required value="" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="invoice_items[${itemIndex}][unit_price]"
                                        placeholder="Unit Price" required value="" oninput="calculatePurchaseInvoiceAmount()">
                                    <input type="text" class="form-control unit" name="invoice_items[${itemIndex}][unit]"
                                        placeholder="Unit" required value="" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Last Purchase</label>
                                <div class="input-group">
                                    <input type="text" class="form-control lp_ref" name="invoice_items[${itemIndex}][lp_ref]"
                                        placeholder="Ref." value="" readonly>
                                    <input type="text" class="form-control lp_price" name="invoice_items[${itemIndex}][lp_price]"
                                        placeholder="Price" value="" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>In Process</label>
                                <div class="input-group">
                                    <input type="text" class="form-control w-25 ip_po_list" name="invoice_items[${itemIndex}][ip_po_list]"
                                        placeholder="PO List" value="" readonly>
                                    <input type="text" class="form-control ip_quantity" name="invoice_items[${itemIndex}][ip_quantity]"
                                        placeholder="Qty" value="" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Consumption 6 Month</label>
                                <input type="text" class="form-control consumption_6_month" name="invoice_items[${itemIndex}][consumption_6_month]"
                                    placeholder="Consumption 6 Month" value="" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Total<span class="text-danger">*</span></label>
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

        function updateRmiTitle(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const titleInput = selectElement.closest('.row').querySelector('.rmi_title');

            if (selectedOption && titleInput) {
                titleInput.value = selectedOption.text.trim();
            }
        }
    </script>
@endsection