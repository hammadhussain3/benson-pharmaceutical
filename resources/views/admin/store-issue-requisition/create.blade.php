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
            <a class="nav-link active" aria-current="page" href="{{ route('store-issue-requisitions.create') }}">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('store-issue-requisitions.production.create') }}">Production</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('store-issue-requisitions.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="is_general" value="1">
                        <input type="hidden" name="is_production" value="0">
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectAllTypeOfProducts(this.value); selectChartOfAccounts(this.value); createStoreRequisitionCode(this.value);">
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
                            <div class="mb-3 col-md-4">
                                <label for="code">Doc. No</label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $newRequisitionCode) }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="type">Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="chart_of_account" id="chart_of_account_id" required>
                                    <option value="">Select Chart Of Account</option>
                                    @if(old('chart_of_account') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($chartOfAccounts->where('company_id', $seletedCompanyId) as $chartOfAccount)
                                            <option value="{{ $chartOfAccount->id }}"
                                                {{ old('chart_of_account') == $chartOfAccount->id ? 'selected' : '' }}>
                                                {{ $chartOfAccount->particular }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="dn_gp">DN/GP</label>
                                <select name="dn_gp" id="dn_gp" class="form-select">
                                    <option {{ old('dn_gp') == '' ? 'selected' : '' }} value="">No</option>
                                    <option {{ old('dn_gp') != '' ? 'selected' : '' }} value="{{ $uniqueValue }}">Yes</option>
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
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="">Items</label>
                                                        <select name="items[{{ $i }}][product]" class="js-example-basic-single select2 products_dropdown" onchange="selectBatchesForProducts(this.value, this); selectPricePacks(this.value, this);" required>
                                                            <option value="">Select Item</option>
                                                            @if(old('items[{{ $i }}][product]') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                                                @php
                                                                    $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                <optgroup label="Raw Materials">
                                                                    @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                        <option value="{{ 'raw_' .$rawMaterialItem->id }}"
                                                                            {{ old("items.$i.product") == 'raw_' .$rawMaterialItem->id ? 'selected' : '' }}>
                                                                            {{ $rawMaterialItem->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Finished Products">
                                                                    @foreach ($productVariations->where('company_id', $seletedCompanyId) as $productVariation)
                                                                        <option value="{{ 'var_' .$productVariation->id }}"
                                                                            {{ old("items.$i.product") == 'var_' .$productVariation->id ? 'selected' : '' }}>
                                                                            {{ 
                                                                                ($productVariation->product->brand_name ?? 'null') . ' | ' .
                                                                                ($productVariation->product->strength ?? 'null') . ' | ' .
                                                                                ($productVariation->dosageForm->name ?? 'null') . ' | ' .
                                                                                ($productVariation->packingType->name ?? 'null') . ' | ' .
                                                                                ($productVariation->packSize->name ?? 'null') 
                                                                            }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="">Batches</label>
                                                        <select name="items[{{ $i }}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                                            <option value="">Select Batch</option>
                                                            @if(old('items[{{ $i }}][product]'))
                                                                @php
                                                                    $rawValue = old("items.$i.product");
                                                                    $batchesForProduct = collect();
                                                                @endphp

                                                                @if(Str::startsWith($rawValue, 'var_'))
                                                                    @php
                                                                        $selectedId = preg_replace('/^var_/', '', $rawValue);
                                                                        $batchesForProduct = $batches->filter(function ($batch) use ($selectedId) {
                                                                            return $batch->items->contains('product_variation_id', $selectedId);
                                                                        });
                                                                    @endphp

                                                                    @foreach ($batchesForProduct as $batch)
                                                                        <option value="{{ $batch->id }}"
                                                                            {{ old("items.$i.batch") == $batch->id ? 'selected' : '' }}>
                                                                            {{ $batch->batch_no }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" oninput="calculateSingleProductAmount()" readonly>
                                                            <input type="text" class="form-control unit" name="items[{{ $i }}][unit]"
                                                                placeholder="UOM" required value="{{ old("items.$i.unit") }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                            placeholder="Quantity" required value="{{ old("items.$i.quantity") }}" oninput="calculateSingleProductAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
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
                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="">Items</label>
                            <select name="items[${ itemIndex }][product]" class="js-example-basic-single select2 products_dropdown" onchange="selectBatchesForProducts(this.value, this)" required></select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="">Batches</label>
                            <select name="items[${ itemIndex }][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                <option value="">Select Batch</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Unit Price</label>
                            <div class="input-group">
                                <input type="number" class="form-control w-25 unit_price" name="items[${ itemIndex }][unit_price]"
                                    placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" oninput="calculateSingleProductAmount()" readonly>
                                <input type="text" class="form-control unit" name="items[${ itemIndex }][unit]"
                                    placeholder="UOM" required value="{{ old("items.$i.unit") }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Quantity</label>
                            <input type="number" class="form-control quantity" name="items[${ itemIndex }][quantity]"
                                placeholder="Quantity" required value="{{ old("items.$i.quantity") }}" oninput="calculateSingleProductAmount()">
                        </div>
                        <div class="mb-3 col-md-4">
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
        const firstDropdownOptions = $(".products_dropdown:first").children().clone();
        $(`#item-group .item-set:last .products_dropdown`).append(firstDropdownOptions);
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