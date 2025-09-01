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
                                <label for="company">Company<span class="text-danger">*</span></label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectAvailableBatchesByCompany(this.value); selectFranchisers(this.value); createSaleInvoiceCode(this.value);">
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
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $newInvoiceCode) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="franchiser_id">Customers<span class="text-danger">*</span></label>
                                <select name="party" id="franchiser_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Customer</option>
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
                            <div class="mb-3 col-md-3">
                                <label for="order_number">Order Number</label>
                                <input type="text" class="form-control" name="order_number" id="order_number"
                                    placeholder="Order Number" required value="{{ old('order_number') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="order_date">Order Date</label>
                                <input type="date" class="form-control" name="order_date" id="order_date"
                                    placeholder="Order Date" required value="{{ old('order_date') }}" max="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="shipped_via">Shipped Via</label>
                                <div class="input-group">
                                    <input type="text" class="form-control w-25" name="shipped_via" id="shipped_via"
                                        placeholder="Shipped Via" required value="{{ old('shipped_via') }}">
                                    <input type="number" class="form-control" name="shipping_cost" id="shipping_cost"
                                        placeholder="Cost" required value="{{ old('shipping_cost', 0) }}" oninput="calculateSaleInvoiceAmount()">
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="returned_amount">Payment Deadline</label>
                                <input type="date" class="form-control" name="payment_deadline" id="payment_deadline"
                                    placeholder="Payment Deadline" required value="{{ old('payment_deadline') }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @php
                                        $count = max(
                                            count(old('invoice_items', [])),
                                            15
                                        );
                                    @endphp
                                    @for ($i = 0; $i < $count; $i++)
                                        <div class="item-set">
                                            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                @if ($i > 0)
                                                    <button type="button" onclick="removeLastItem()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <div class="row">
                                                    <div class="mb-3 col-md-3">
                                                        <label for="">Batch #<span class="text-danger">*</span></label>
                                                        <select name="invoice_items[{{ $i }}][batch]" class="js-example-basic-single select2 company_batches_dropdown" onchange="selectAvailablePVByBatch(this.value, this); getBatchDetails(this.value, this);" required>
                                                            <option value="">Select Batch</option>
                                                            @if(old('company') || !auth()->user()->hasRole('Superadmin'))
                                                                @php
                                                                    $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                @foreach ($batches->where('company_id', $seletedCompanyId) as $batch)
                                                                    <option value="{{ $batch->id }}"
                                                                        {{ old("invoice_items.$i.batch") == $batch->id ? 'selected' : '' }}>
                                                                        {{ $batch->batch_no }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label for="">Product Code</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][product_code]" value="{{ old("invoice_items.$i.product_code") }}" readonly class="form-control product_code">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="">Products<span class="text-danger">*</span></label>
                                                        <select name="invoice_items[{{ $i }}][product]" class="js-example-basic-single select2 product_variations_dropdown" onchange="getTradePrice(this.value, this); getProductVariationDetails(this.value, this); getProductStockQuantity(this.value, this);" required>
                                                            <option value="">Select Product</option>
                                                            @if(old("invoice_items.$i.batch"))
                                                                @php
                                                                    $batch = $batches->where('id', old("invoice_items.$i.batch"))->first();
                                                                    $variationIds = optional($batch->items)->where('batch_id', $batch->id ?? null)->pluck('product_variation_id')->unique()->toArray();
                                                                @endphp
                                                                @foreach ($productVariations->whereIn('id', $variationIds) as $productVariation)
                                                                    <option value="{{ $productVariation->id }}"
                                                                        {{ old("invoice_items.$i.product") == $productVariation->id ? 'selected' : '' }}>
                                                                        {{ 
                                                                            ($productVariation->product->brand_name ?? 'null') . ' | ' .
                                                                            ($productVariation->product->strength ?? 'null') . ' | ' .
                                                                            ($productVariation->dosageForm->name ?? 'null') . ' | ' .
                                                                            ($productVariation->packingType->name ?? 'null') . ' | ' .
                                                                            ($productVariation->packSize->name ?? 'null') 
                                                                        }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label for="">MFG Date</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][mfg_date]" value="{{ old("invoice_items.$i.mfg_date") }}" readonly class="form-control mfg_date">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label for="">EXP Date</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][exp_date]" value="{{ old("invoice_items.$i.exp_date") }}" readonly class="form-control exp_date">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label>QTY. Pack<span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control product_quantity" name="invoice_items[{{ $i }}][quantity]"
                                                            placeholder="Pack Quantity" required value="{{ old("invoice_items.$i.quantity") }}" oninput="calculateSaleInvoiceAmount()">
                                                        <input type="hidden" name="invoice_items[{{ $i }}][available_quantity]" class="available_quantity_input" value="{{ old("invoice_items.$i.available_quantity", 0) }}">
                                                        <div id="invoice_items_{{ $i }}_available_quantity" class="form-text text-primary available_quantity">Available quantity is {{ old("invoice_items.$i.available_quantity", 0) }}</div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label>Rate</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price batch_trade_price" name="invoice_items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("invoice_items.$i.unit_price") }}" oninput="calculateSaleInvoiceAmount()" readonly>
                                                            <input type="hidden" class="form-control" name="invoice_items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="Pack" readonly>
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="">Value</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][value]" value="{{ old("invoice_items.$i.value", 0) }}" readonly class="form-control value">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
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
                                                    <div class="mb-3 col-md-2">
                                                        <label for="">Discount Value</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][discount_value]" value="{{ old("invoice_items.$i.discount_value", 0) }}" readonly class="form-control discount_value">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="">Exclusive Sales Tax</label>
                                                        <input type="text" name="invoice_items[{{ $i }}][exclusive_sales]" value="{{ old("invoice_items.$i.exclusive_sales", 0) }}" readonly class="form-control exclusive_sales">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label>Sales Tax</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control tax_rate" name="invoice_items[{{ $i }}][tax_rate]"
                                                                placeholder="Tax Rate" required value="{{ old("invoice_items.$i.tax_rate") }}" oninput="calculateSaleInvoiceAmount()">
                                                            <input type="number" class="form-control tax_amount" value="{{ old("invoice_items.$i.tax_amount") }}" name="invoice_items[{{ $i }}][tax_amount]" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 col-md-2">
                                                        <label>Inclusive Sales Tax</label>
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
                        </div>
                        <div class="position-sticky bottom-0 bg-white w-100 start-0 card" style="z-index: 99">
                            <div class="card-body row">
                                <div class="mb-3 col-md-2">
                                    <label for="">QTY Pack</label>
                                    <input type="text" class="form-control" id="total_quantity" name="total_quantity" value="{{ old('total_quantity', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="">Value</label>
                                    <input type="text" class="form-control" id="total_value" name="total_value" value="{{ old('total_value', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="">Discount Value</label>
                                    <input type="text" class="form-control" id="total_discount_value" name="total_discount_value" value="{{ old('total_discount_value', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="">Exclusive Sales Tax</label>
                                    <input type="text" class="form-control" id="total_exclusive_sales" name="total_exclusive_sales" value="{{ old('total_exclusive_sales', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="">Sales Tax</label>
                                    <input type="text" class="form-control" id="total_tax" name="total_tax" value="{{ old('total_tax', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="returned_amount">Inclusive Sales Tax</label>
                                    <input type="number" class="form-control" name="total_amount" id="total_amount"
                                        placeholder="Total Amount" required value="{{ old('total_amount', 0) }}" readonly>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="note">Special Note</label>
                                    <textarea type="text" class="form-control" name="note" id="note"
                                        placeholder="Note" required>{{ old('note') }}</textarea>
                                </div>
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
                    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Item ${itemIndex + 1}</h4><button type="button" onclick="removeLastItem()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="">Batch #<span class="text-danger">*</span></label>
                                <select name="invoice_items[${itemIndex}][batch]" class="js-example-basic-single select2 company_batches_dropdown" onchange="selectAvailablePVByBatch(this.value, this); getBatchDetails(this.value, this);" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="">Product Code</label>
                                <input type="text" name="invoice_items[${itemIndex}][product_code]" class="form-control product_code" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="">Products<span class="text-danger">*</span></label>
                                <select name="invoice_items[${itemIndex}][product]" class="js-example-basic-single select2 product_variations_dropdown" onchange="getTradePrice(this.value, this); getProductVariationDetails(this.value, this);" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="">MFG Date</label>
                                <input type="text" name="invoice_items[${itemIndex}][mfg_date]" class="form-control mfg_date" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="">EXP Date</label>
                                <input type="text" name="invoice_items[${itemIndex}][exp_date]" class="form-control exp_date" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>QTY Pack<span class="text-danger">*</span></label>
                                <input type="number" class="form-control product_quantity" name="invoice_items[${itemIndex}][quantity]"
                                    placeholder="Pack Quantity" required value="" oninput="calculateSaleInvoiceAmount()">
                                <input type="hidden" name="invoice_items[{{ $i }}][available_quantity]" class="available_quantity_input" value="{{ old("invoice_items.$i.available_quantity", 0) }}">
                                <div id="invoice_items_${itemIndex}_available_quantity" class="form-text text-primary available_quantity">Available quantity is 0</div>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Rate</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price batch_trade_price" name="invoice_items[${itemIndex}][unit_price]"
                                        placeholder="Unit Price" required value="" oninput="calculateSaleInvoiceAmount()" readonly>
                                    <input type="hidden" class="form-control" name="invoice_items[${itemIndex}][unit]"
                                        placeholder="Unit" required value="Pack" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="">Value</label>
                                <input type="text" name="invoice_items[${itemIndex}][value]" class="form-control value" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
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
                            <div class="mb-3 col-md-2">
                                <label for="">Discount Value</label>
                                <input type="text" name="invoice_items[${itemIndex}][discount_value]" class="form-control discount_value" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="">Exclusive Sales Tax</label>
                                <input type="text" name="invoice_items[${itemIndex}][exclusive_sales]" class="form-control exclusive_sales" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Sales Tax</label>
                                <div class="input-group">
                                    <input type="number" class="form-control tax_rate" name="invoice_items[${itemIndex}][tax_rate]"
                                        placeholder="Tax Rate" required value="" oninput="calculateSaleInvoiceAmount()">
                                    <input type="number" class="form-control tax_amount" name="invoice_items[${itemIndex}][tax_amount]" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Inclusive Sales Tax</label>
                                <input type="number" class="form-control total_item_amount" name="invoice_items[${itemIndex}][total_amount]"
                                    placeholder="Total" required value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $("#item-group").append(html);
            // Clone the options from the first dropdown and append to the new dropdown
            const firstDropdownOptions = $(".company_batches_dropdown:first").children().clone().removeAttr("selected");
            $(`#item-group .item-set:last .company_batches_dropdown`).append(firstDropdownOptions);
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

        function getBatchDetails(batchId, target) {
            const batchArray = Object.values(@json($batches));
            
            const itemSet = target.closest('.item-set');
            if (!itemSet) return;

            var selectMfgDate = itemSet.getElementsByClassName('mfg_date')[0];
            var selectExpDate = itemSet.getElementsByClassName('exp_date')[0];
            
            var selectedBatch = batchArray.find(batch => batch.id == batchId);

            if (selectedBatch) {
                const formatDate = (dateStr) => {
                    const date = new Date(dateStr);
                    const day = date.getDate().toString().padStart(2, '0');
                    const month = date.toLocaleString('en-US', { month: 'short' });
                    const year = date.getFullYear();
                    return `${day} ${month}, ${year}`;
                };

                if (selectMfgDate) selectMfgDate.value = formatDate(selectedBatch.mfg_date);
                if (selectExpDate) selectExpDate.value = formatDate(selectedBatch.exp_date);
            } else {
                console.warn("Batch not found for ID:", batchId);
            }
        }

        function getProductVariationDetails(productVariationId, target) {
            const productVariationArray = Object.values(@json($productVariations));
            
            const itemSet = target.closest('.item-set');
            if (!itemSet) return;

            var selectProductCode = itemSet.getElementsByClassName('product_code')[0];
            
            var selectedProductVariation = productVariationArray.find(productVariation => productVariation.id == productVariationId);

            if (selectedProductVariation) {
                selectProductCode.value = selectedProductVariation.code
            } else {
                console.warn("Batch not found for ID:", productVariationId);
            }
        }

        function getProductStockQuantity(productVariationId, target) {
            const availableItemArray = Object.values(@json($availableItems));

            const itemSet = target.closest('.item-set');
            if (!itemSet) return;

            const selectAvailableQuantity = itemSet.querySelector('.available_quantity');
            const batchId = itemSet.querySelector('.company_batches_dropdown').value;
            const selectAvailableQuantityInput = itemSet.querySelector('.available_quantity_input');

            const selectedAvailableItem = availableItemArray.find(
                item => item.product_variation_id == productVariationId && item.batch_id == Number(batchId)
            );

            if (selectedAvailableItem) {
                selectAvailableQuantity.innerText = 'Available quantity is ' + selectedAvailableItem.quantity_available;
                selectAvailableQuantityInput.value = selectedAvailableItem.quantity_available;
            } else {
                selectAvailableQuantity.innerText = 'No stock found';
                console.warn("Product not found for batch:", batchId, "productVariationId:", productVariationId);
            }
        }
    </script>
@endsection