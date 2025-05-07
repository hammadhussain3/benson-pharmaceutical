@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Finished Goods Receiving Note</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('finished-goods-receivings.index') }}">Finished Goods Receiving Notes</a></li>
                    <li class="breadcrumb-item active">Edit Finished Goods Receiving Note</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('finished-goods-receivings.update', $finishedGoodsReceiving->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectProducts(this.value);">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $finishedGoodsReceiving->company_id) == $company->id ? 'selected' : '' }}>
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
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $finishedGoodsReceiving->code) }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="product_id">Brand</label>
                                <select name="product" id="product_id" class="js-example-basic-single select2" required onchange="selectBatches(this.value);">
                                    <option value="">Select Brand</option>
                                    @php
                                        $seletedCompanyId = old('company', $finishedGoodsReceiving->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($products->where('company_id', $seletedCompanyId) as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product', $finishedGoodsReceiving->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="batch_id">Batch</label>
                                <select name="batch" id="batch_id" class="js-example-basic-single select2" required onchange="selectProductVariationsByBatch(this.value);">
                                    <option value="">Select Batch</option>
                                    @php
                                        $seletedCompanyId = old('company', $finishedGoodsReceiving->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($batches->where('company_id', $seletedCompanyId)->where('product_id', old('product', $finishedGoodsReceiving->product_id)) as $batch)
                                        <option value="{{ $batch->id }}"
                                            {{ old('batch', $finishedGoodsReceiving->batch_id) == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->batch_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @for ($i = 0; $i < count(old('items', $finishedGoodsReceiving->items)); $i++)
                                        <div class="item-set">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                @if ($i > 0)
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="">Product</label>
                                                        <select name="items[{{ $i }}][product_variation]" class="js-example-basic-single select2 product_variations_dropdown" required>
                                                            <option value="">Select Product</option>
                                                            @php
                                                                $seletedBatchId = old('batch', $finishedGoodsReceiving->batch_id);
                                                                $variationIds = $batch->items->pluck('product_variation_id')->unique()->toArray();
                                                            @endphp
                                                            @foreach ($productVariations->whereIn('id', $variationIds) as $productVariation)
                                                                <option value="{{ $productVariation->id }}"
                                                                    {{ old("items.$i.product_variation", $finishedGoodsReceiving->items[$i]->product_variation_id) == $productVariation->id ? 'selected' : '' }}>
                                                                    {{ $productVariation->product->brand_name }} | {{ $productVariation->packingType->name }} | {{ $productVariation->packSize->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                placeholder="Cost Price" required value="{{ old("items.$i.unit_price", $finishedGoodsReceiving->items[$i]->unit_price) }}" oninput="calculateSingleProductAmount()">
                                                            <input type="text" class="form-control" name="items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("items.$i.unit", $finishedGoodsReceiving->items[$i]->unit) }}" readonly>
                                                          </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity_received]"
                                                            placeholder="Product Quantity" required value="{{ old("items.$i.quantity_received", $finishedGoodsReceiving->items[$i]->quantity_received) }}" oninput="calculateSingleProductAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                            placeholder="Total" required value="{{ old("items.$i.total", $finishedGoodsReceiving->items[$i]->total) }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="button" onclick="addItem()" class="btn btn-primary">Add Item</button>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-secondary" href="{{ route('finished-goods-receivings.index') }}">Cancel</a>
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
                        <h4 class="card-title mb-0">Item ${ itemIndex + 1 }</h4>
                        @if ($i > 0)
                            <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        @endif
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="">Product Variation</label>
                                <select name="items[${ itemIndex }][product_variation]" class="js-example-basic-single select2 product_variations_dropdown" required></select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="items[${ itemIndex }][unit_price]"
                                        placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" oninput="calculateSingleProductAmount()">
                                    <input type="text" class="form-control" name="items[${ itemIndex }][unit]"
                                        placeholder="Unit" required value="{{ old("items.$i.unit") }}">
                                    </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Product Quantity</label>
                                <input type="number" class="form-control quantity" name="items[${ itemIndex }][quantity_received]"
                                    placeholder="Product Quantity" required value="{{ old("items.$i.quantity_received") }}" oninput="calculateSingleProductAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Total</label>
                                <input type="number" class="form-control product_total" name="items[${ itemIndex }][total]"
                                    placeholder="Total" required value="{{ old("items.$i.total", 0) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $("#item-group").append(html);
            const firstDropdownOptions = $(".product_variations_dropdown:first").children().clone();
            $(`#item-group .item-set:last .product_variations_dropdown`).append(firstDropdownOptions);
            itemIndex++;
            $('.js-example-basic-single').select2({});
        }

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