@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Batch</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('batches.index') }}">Batches</a></li>
                    <li class="breadcrumb-item active">Edit Batch</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('batches.update', $batch->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="form-control" required value="{{ old('company') }}" @role('Superadmin') onchange="selectProducts(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $batch->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-4">
                                <label for="product_id">Brand</label>
                                <select class="js-example-basic-single select2" name="product" id="product_id" required onchange="selectProductVariations(this.value);">
                                    <option value="">Select Product</option>
                                    @php
                                        $seletedCompanyId = old('company', $batch->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($products->where('company_id', $seletedCompanyId) as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product', $batch->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="batch_no">Batch No</label>
                                <input type="text" class="form-control" name="batch_no" id="batch_no"
                                    placeholder="Batch No" value="{{ old('batch_no', $batch->batch_no) }}" required>
                                <div class="invalid-feedback">Please provide a Batch No.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="batch_size">Batch Size</label>
                                <input type="text" class="form-control" name="batch_size" placeholder="Batch Size"
                                    value="{{ old('batch_size', $batch->batch_size) }}" required>
                                <div class="invalid-feedback">Please provide an Batch Size.</div>
                            </div>

                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @php
                                        $count = max(
                                            count(old('items', $batch->items)),
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
                                                    <div class="mb-3 col-md-12">
                                                        <label for="">Products</label>
                                                        <select name="items[{{ $i }}][product_variation]" class="js-example-basic-single select2 product_variations_dropdown" required>
                                                            <option value="">Select Product</option>
                                                            @php
                                                                $seletedProductId = old('product', $batch->product_id);
                                                            @endphp
                                                            @foreach ($productVariations->where('product_id', $seletedProductId) as $productVariation)
                                                                <option value="{{ $productVariation->id }}"
                                                                    {{ old("items.$i.product_variation", $batch->items[$i]->product_variation_id) == $productVariation->id ? 'selected' : '' }}>
                                                                    {{ $productVariation->product_name ?? null }} | {{ $productVariation->strength ?? null }} | {{ $productVariation->dosage_form_name ?? null }} | {{ $productVariation->packing_type_name ?? null }} | {{ $productVariation->pack_size_name ?? null }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label>Quantity (Pack)</label>
                                                        <input type="number" class="form-control product_quantity" name="items[{{ $i }}][quantity]"
                                                            placeholder="Product Quantity" required value="{{ old("items.$i.quantity", $batch->items[$i]->quantity) }}" oninput="calculatePurchaseInvoiceAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label>Trade Price</label>
                                                        <input type="number" class="form-control trade_price" name="items[{{ $i }}][trade_price]"
                                                            placeholder="Total" required value="{{ old("items.$i.trade_price", $batch->items[$i]->trade_price) }}">
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

                            <div class="mb-3 col-md-6">
                                <label for="description">Manufactured Date</label>
                                <input type="date" class="form-control" name="mfg_date"
                                    required value="{{ old('mfg_date',$batch->mfg_date) }}">
                                <div class="invalid-feedback">Please provide a Manufactured Date.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="description">Expiry Date</label>
                                <input type="date" class="form-control" name="exp_date"
                                    required value="{{ old('exp_date',$batch->exp_date) }}">
                                <div class="invalid-feedback">Please provide a Expiry Date.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date"
                                    required value="{{ old('start_date',$batch->start_date) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date"
                                    value="{{ old('end_date',$batch->end_date) }}">
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Status</label>
                                <select class="js-example-basic-single select2" name="status" required>
                                        <option value="inprocess" {{ old('status', $batch->status) == 'inprocess' ? 'selected' : '' }}>
                                            In-Process
                                        </option>
                                        <option value="completed" {{ old('status', $batch->status) == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                </select>
                                <div class="invalid-feedback">Please select a Status.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('batches.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productVariations = @json($productVariations->pluck('trade_price', 'id'));
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
                            <div class="mb-3 col-md-12">
                                <label for="">Products</label>
                                <select name="items[${itemIndex}][product_variation]" class="js-example-basic-single select2 product_variations_dropdown" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>Quantity (Pack)</label>
                                <input type="number" class="form-control product_quantity" name="items[${itemIndex}][quantity]"
                                    placeholder="Unit Price" required value="" oninput="calculatePurchaseInvoiceAmount()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>Trade Price</label>
                                <input type="number" class="form-control trade_price" name="items[${itemIndex}][trade_price]"
                                    placeholder="Total" required value="0">
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
                calculatePurchaseInvoiceAmount();
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
        $(document).on('change', '.product_variations_dropdown', function() {
            console.log(productVariations);
            const selectedId = $(this).val(); // Get selected product_variation_id
            const tradePrice = productVariations[selectedId] || 0; // Lookup trade price

            $(this).closest('.item-set').find('.trade_price').val(tradePrice);
        });
    </script>
@endsection
