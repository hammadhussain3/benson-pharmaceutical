@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Store Issue Requisition</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('store-issue-requisitions.index') }}">Store Issue Requisitions</a></li>
                    <li class="breadcrumb-item active">Add Store Issue Requisition</li>
                </ul>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('store-issue-requisitions.create') }}">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('store-issue-requisitions.production.create') }}">Production</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('store-issue-requisitions.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="is_general" value="0">
                        <input type="hidden" name="is_production" value="1">
                        <div class="form-row row">
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectBatchesByCompany(this.value); selectRawMaterialItems(this.value); createStoreRequisitionCode(this.value);">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Doc. No</label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $newRequisitionCode) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="batch_id">Batch</label>
                                <select class="js-example-basic-single select2" name="batch" id="batch_id" required onchange="selectSingleFieldPVByCompany(this.value);">
                                    <option value="">Select Batch</option>
                                    @if(old('batch') || old('company'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($batches->where('company_id', $seletedCompanyId) as $batch)
                                            <option value="{{ $batch->id }}"
                                                {{ old('batch') == $batch->id ? 'selected' : '' }}>
                                                {{ $batch->batch_no }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="product_variation_id">Product</label>
                                <select class="js-example-basic-single select2" name="product_variation" id="product_variation_id" required>
                                    <option value="">Select Product</option>
                                    @if(old('batch'))
                                        @php
                                            $batch = App\Models\Batch::findOrFail(old('batch'));
                                            $variationIds = $batch->items->where('batch_id', $batch->id)->pluck('product_variation_id')->unique()->toArray();
                                        @endphp
                                        @foreach ($productVariations->whereIn('id', $variationIds) as $productVariation)
                                            <option value="{{ $productVariation->id }}"
                                                {{ old("product_variation") == $productVariation->id ? 'selected' : '' }}>
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
                            <div class="mb-3 col-md-6">
                                <label for="dn_gp">DN/GP</label>
                                <select name="dn_gp" id="dn_gp" class="form-select">
                                    <option {{ old('dn_gp') == '' ? 'selected' : '' }} value="">No</option>
                                    <option {{ old('dn_gp') == $uniqueValue ? 'selected' : '' }} value="{{ $uniqueValue }}">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @php
                                        $count = max(
                                            count(old('items', [])),
                                            1
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
                                                    <div class="mb-3 col-md-4">
                                                        <label for="">Raw Material</label>
                                                        <select name="items[{{ $i }}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required onchange="selectPricePacks(this.value, this);">
                                                            <option value="">Select Raw Material</option>
                                                            @if(old('items[{{ $i }}][raw_material_item]') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                                                @php
                                                                    $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                    <option value="{{ $rawMaterialItem->id }}"
                                                                        {{ old("items.$i.raw_material_item") == $rawMaterialItem->id ? 'selected' : '' }}>
                                                                        {{ $rawMaterialItem->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" readonly oninput="calculateSingleProductAmount()">
                                                            <input type="text" class="form-control unit" name="items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("items.$i.unit") }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                            placeholder="Quantity" required value="{{ old("items.$i.quantity") }}" oninput="calculateSingleProductAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                            placeholder="Total" required value="{{ old("items.$i.total") }}" readonly>
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
                        <a class="btn btn-secondary" href="{{ route('store-issue-requisitions.index') }}">Cancel</a>
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
                        <h4 class="card-title mb-0">Item ${ itemIndex + 1 }</h4>
                        <button type="button" onclick="removeLastItem()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="">Raw Material</label>
                                <select name="items[${ itemIndex }][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required onchange="selectPricePacks(this.value, this);"></select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="items[${ itemIndex }][unit_price]"
                                        placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" oninput="calculateSingleProductAmount()" readonly>
                                    <input type="text" class="form-control unit" name="items[${ itemIndex }][unit]"
                                        placeholder="Unit" required value="{{ old("items.$i.unit") }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Quantity</label>
                                <input type="number" class="form-control quantity" name="items[${ itemIndex }][quantity]"
                                    placeholder="Quantity" required value="{{ old("items.$i.quantity") }}" oninput="calculateSingleProductAmount()">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label>Total</label>
                                <input type="number" class="form-control product_total" name="items[${ itemIndex }][total]"
                                    placeholder="Total" required value="{{ old("items.$i.total") }}" readonly>
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
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
    </script>
@endsection