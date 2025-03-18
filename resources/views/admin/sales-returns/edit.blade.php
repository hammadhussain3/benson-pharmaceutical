@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Sales Return</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sales-returns.index') }}">Sales Returns</a></li>
                    <li class="breadcrumb-item active">Edit Sales Return</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales-returns.update', $salesReturn->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectProductVariationsByCompany(this.value); selectFranchisers(this.value); createSalesReturnCode(this.value);">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $salesReturn->company_id) == $company->id ? 'selected' : '' }}>
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
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $salesReturn->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="franchiser_id">Franchisers</label>
                                <select name="party" id="franchiser_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Franchiser</option>
                                    @php
                                        $seletedCompanyId = old('company', $salesReturn->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($franchisers->where('company_id', $seletedCompanyId)->where('is_distributor', '1') as $franchiser)
                                        <option value="{{ $franchiser->id }}"
                                            {{ old('party', $salesReturn->party_id) == $franchiser->id ? 'selected' : '' }}>
                                            {{ $franchiser->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @for ($i = 0; $i < count(old('items', $salesReturn->items)); $i++)
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
                                                        <label for="">Products</label>
                                                        <select name="items[{{ $i }}][product]" class="js-example-basic-single select2 product_variations_dropdown" 
                                                            onchange="selectBatchesByProductVariation(this.value, this)" required>
                                                            <option value="">Select Products</option>
                                                            @php
                                                                $seletedCompanyId = old('company', $salesReturn->company_id) ?? auth()->user()->employee->company_id;
                                                            @endphp
                                                            @foreach ($productVariations->where('company_id', $seletedCompanyId) as $productVariation)
                                                                <option value="{{ $productVariation->id }}"
                                                                    {{ old("items.$i.product", $salesReturn->items[$i]->product_variation_id) == $productVariation->id ? 'selected' : '' }}>
                                                                    {{ $productVariation->product->name. ' | ' .$productVariation->packingType->name. ' | ' .$productVariation->packSize->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="">Batches</label>
                                                        <select name="items[{{ $i }}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                                            <option value="">Select Batch</option>
                                                            @php
                                                                $selectedProductVariationId = old("items.$i.product", $salesReturn->items[$i]->product_variation_id);
                                                                $productVariation = $productVariations->find($selectedProductVariationId);
                                                                $productId = $productVariation->product_id ?? null;
                                                                $seletedCompanyId = old('company', $salesReturn->company_id) ?? auth()->user()->employee->company_id;
                                                            @endphp
                                                            @foreach ($batches->where('product_id', $productId)->where('company_id', $seletedCompanyId) as $batch)
                                                                <option value="{{ $batch->id }}"
                                                                    {{ old("items.$i.batch", $salesReturn->items[$i]->batch_id) == $batch->id ? 'selected' : '' }}>
                                                                    {{ $batch->batch_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>                                                    
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("items.$i.unit_price", $salesReturn->items[$i]->unit_price) }}" oninput="calculateSalesReturnAmount()">
                                                            <input type="text" class="form-control" name="items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("items.$i.unit", $salesReturn->items[$i]->unit) }}">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Pack Quantity</label>
                                                        <input type="number" class="form-control product_quantity" name="items[{{ $i }}][quantity]"
                                                            placeholder="Pack Quantity" required value="{{ old("items.$i.quantity", $salesReturn->items[$i]->quantity) }}" oninput="calculateSalesReturnAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Tax Rate</label>
                                                        <input type="number" class="form-control tax_rate" name="items[{{ $i }}][tax_rate]"
                                                            placeholder="Tax Rate" required value="{{ old("items.$i.tax_rate", $salesReturn->items[$i]->tax_rate) }}" oninput="calculateSalesReturnAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="status">Discount</label>
                                                        <div class="input-group">
                                                            <select class="form-select" name="items[{{ $i }}][discount_type]" required>
                                                                <option value="flat" {{ old("items.$i.discount_type", $salesReturn->items[$i]->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                <option value="percent" {{ old("items.$i.discount_type", $salesReturn->items[$i]->discount_type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                                            </select>
                                                            <input type="number" class="form-control w-25 discount" name="items[{{ $i }}][discount]"
                                                                placeholder="Discount" required value="{{ old("items.$i.discount", $salesReturn->items[$i]->discount) }}" oninput="calculateSalesReturnAmount()">
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control total_item_amount" name="items[{{ $i }}][total_amount]"
                                                            placeholder="Total" required value="{{ old("items.$i.total_amount", $salesReturn->items[$i]->total_amount) }}" readonly>
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
                                <label for="inclusive_tax">Inclusive Tax</label>
                                <input type="number" class="form-control" name="inclusive_tax" id="inclusive_tax"
                                    placeholder="Inclusive Tax" required value="{{ old('inclusive_tax', $salesReturn->inclusive_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="tax_rate">Tax Rate</label>
                                <input type="number" class="form-control" name="tax_rate" id="tax_rate"
                                    placeholder="Tax Rate" required value="{{ old('tax_rate', $salesReturn->tax_rate) }}" oninput="calculateSalesReturnAmount()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="total_tax">Total Tax</label>
                                <input type="number" class="form-control" name="total_tax" id="total_tax"
                                    placeholder="Total Tax" required value="{{ old('total_tax', $salesReturn->total_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="exclusive_tax">Exclusive Tax</label>
                                <input type="number" class="form-control" name="exclusive_tax" id="exclusive_tax"
                                    placeholder="Exclusive Tax" required value="{{ old('exclusive_tax', $salesReturn->exclusive_tax) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount Type</label>
                                <select class="js-example-basic-single select2" name="discount_type" required id="discount_type">
                                    <option value="flat" {{ old("discount_type", $salesReturn->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                    <option value="percent" {{ old("discount_type", $salesReturn->discount_type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="items_cost_with_tax">Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount"
                                    placeholder="Discount" required value="{{ old('discount', $salesReturn->discount) }}" oninput="calculateSalesReturnAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="returned_amount">Total Amount</label>
                                <input type="number" class="form-control" name="total_amount" id="total_amount"
                                    placeholder="Total Amount" required value="{{ old('total_amount', $salesReturn->total_amount) }}" readonly>
                            </div>
                            @if(auth()->user()->hasPermission('Document Approval Edit'))
                                <div class="mb-3 col-md-6">
                                    <label for="is_approved">Is Approved</label>
                                    <select name="is_approved" id="is_approved" class="form-control" required>
                                        <option value="1" {{ old('is_approved', $salesReturn->is_approved) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_approved', $salesReturn->is_approved) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('sales-returns.index') }}">Cancel</a>
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
                                <label for="">Products</label>
                                <select name="items[${itemIndex}][product]" class="js-example-basic-single select2 product_variations_dropdown" onchange="selectBatchesByProductVariation(this.value, this)" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="">Batches</label>
                                <select name="items[${itemIndex}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                    <option value="">Select Batch</option>
                                </select>
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="items[${itemIndex}][unit_price]"
                                        placeholder="Unit Price" required value="" oninput="calculateSalesReturnAmount()">
                                    <input type="text" class="form-control" name="items[${itemIndex}][unit]"
                                        placeholder="Unit" required value="">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Pack Quantity</label>
                                <input type="number" class="form-control product_quantity" name="items[${itemIndex}][quantity]"
                                    placeholder="Pack Quantity" required value="" oninput="calculateSalesReturnAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Tax Rate</label>
                                <input type="number" class="form-control tax_rate" name="items[${itemIndex}][tax_rate]"
                                    placeholder="Tax Rate" required value="" oninput="calculateSalesReturnAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Discount</label>
                                <div class="input-group">
                                    <select class="form-select" name="items[${itemIndex}][discount_type]" required>
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                    <input type="number" class="form-control w-25 discount" name="items[${itemIndex}][discount]"
                                        placeholder="Discount" required value="0" oninput="calculateSalesReturnAmount()">
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Total</label>
                                <input type="number" class="form-control total_item_amount" name="items[${itemIndex}][total_amount]"
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
                calculateSalesReturnAmount();
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
    </script>
@endsection