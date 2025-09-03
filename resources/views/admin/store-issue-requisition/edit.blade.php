@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Store Issue Requisition</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('store-issue-requisitions.index') }}">Store Issue Requisitions</a></li>
                    <li class="breadcrumb-item active">Edit Store Issue Requisition</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-white py-2">
                    <h4 class="card-title mb-0">{{ $requisition->is_general == '1' ? 'General' : 'Production' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store-issue-requisitions.update', $requisition->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_general" value="{{ $requisition->is_general }}">
                        <input type="hidden" name="is_production" value="{{ $requisition->is_production }}">
                        <div class="form-row row">
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company_id" class="js-example-basic-single select2" required 
                                        onchange="createStoreRequisitionCode(this.value);
                                        @if ($requisition->is_general == '1') selectChartOfAccounts(this.value);
                                        @elseif ($requisition->is_production == '1') selectBatchesByCompany(this.value);
                                        @endif
                                        @if ($requisition->is_general == '1') selectAllTypeOfProducts(this.value);
                                        @elseif ($requisition->is_production == '1') selectRawMaterialItems(this.value);
                                        @endif">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company', $requisition->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="mb-3 {{ $requisition->is_general == '1' ? 'col-md-4' : 'col-md-6'; }}">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" readonly value="{{ old('code', $requisition->code) }}">
                            </div>
                            @if ($requisition->is_production == '1')
                                <div class="mb-3 col-md-6">
                                    <label for="batch_id">Batch</label>
                                    <select class="js-example-basic-single select2" name="batch" id="batch_id" required onchange="selectSingleFieldPVByCompany(this.value);">
                                        <option value="">Select Batch</option>
                                        @php
                                            $seletedCompanyId = old('company', $requisition->company_id) ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($batches->where('company_id', $seletedCompanyId) as $batch)
                                            <option value="{{ $batch->id }}"
                                                {{ old('batch', $requisition->batch_id) == $batch->id ? 'selected' : '' }}>
                                                {{ $batch->batch_no }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if ($requisition->is_general == '1')
                                <div class="mb-3 col-md-4">
                                    <label for="type">Chart of Accounts</label>
                                    <select class="js-example-basic-single select2" name="chart_of_account" id="chart_of_account_id" required>
                                        <option value="">Select Chart Of Account</option>
                                        @php
                                            $seletedCompanyId = old('company', $requisition->company_id) ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($chartOfAccounts->where('company_id', $seletedCompanyId) as $chartOfAccount)
                                            <option value="{{ $chartOfAccount->id }}"
                                                {{ old('chart_of_account', $requisition->chart_of_account_id) == $chartOfAccount->id ? 'selected' : '' }}>
                                                {{ $chartOfAccount->particular }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif ($requisition->is_production == '1')
                                <div class="mb-3 col-md-6">
                                    <label for="product_variation_id">Product</label>
                                    <select class="js-example-basic-single select2" name="product_variation" id="product_variation_id" required onchange="selectBatches(this.value)">
                                        <option value="">Select Product</option>
                                        @php
                                            $batch = App\Models\Batch::findOrFail(old('batch', $requisition->batch_id));
                                            $variationIds = $batch->items->where('batch_id', $batch->id)->pluck('product_variation_id')->unique()->toArray();
                                        @endphp
                                        @foreach ($productVariations->whereIn('id', $variationIds) as $productVariation)
                                            <option value="{{ $productVariation->id }}"
                                                {{ old("product_variation", $requisition->product_variation_id) == $productVariation->id ? 'selected' : '' }}>
                                                {{ 
                                                    ($productVariation->product->brand_name ?? 'null') . ' | ' .
                                                    ($productVariation->product->strength ?? 'null') . ' | ' .
                                                    ($productVariation->dosageForm->name ?? 'null') . ' | ' .
                                                    ($productVariation->packingType->name ?? 'null') . ' | ' .
                                                    ($productVariation->packSize->name ?? 'null') 
                                                }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="mb-3 {{ $requisition->is_general == '1' ? 'col-md-4' : 'col-md-6'; }}">
                                <label for="dn_gp">DN GP</label>
                                <select name="dn_gp" id="dn_gp" class="form-select">
                                    <option {{ old('dn_gp', $requisition->dn_gp) == '' ? 'selected' : '' }} value="">No</option>
                                    <option {{ old('dn_gp', $requisition->dn_gp) != '' ? 'selected' : '' }} value="{{ $requisition->dn_gp ?? $uniqueValue  }}">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @for ($i = 0; $i < count(old('items', $requisition->items)); $i++)
                                        <div class="item-set">
                                            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                                @if ($i > 0)
                                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </div>
                                            <div class="card-body px-0 pb-0">
                                                <div class="row">
                                                    @if ($requisition->is_general == '1')
                                                        <div class="mb-3 col-md-6">
                                                            <label for="">Product</label>
                                                            <select name="items[{{ $i }}][product]" class="js-example-basic-single select2 products_dropdown" onchange="selectBatchesForProducts(this.value, this)" required>
                                                                <option value="">Select Product</option>
                                                                @php
                                                                    $seletedCompanyId = old('company', $requisition->company_id) ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                <optgroup label="Raw Materials">
                                                                    @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                        <option value="{{ 'raw_' .$rawMaterialItem->id }}"
                                                                            {{ old("items.$i.product", 'raw_' .$requisition->items[$i]->raw_material_item_id ?? '') == 'raw_' .$rawMaterialItem->id ? 'selected' : '' }}>
                                                                            {{ $rawMaterialItem->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Finished Product">
                                                                    @foreach ($productVariations->where('company_id', $seletedCompanyId) as $productVariation)
                                                                        <option value="{{ 'var_' .$productVariation->id }}"
                                                                            {{ old("items.$i.product", 'var_' .$requisition->items[$i]->product_variation_id ?? '') == 'var_' .$productVariation->id ? 'selected' : '' }}>
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
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="">Batches</label>
                                                            <select name="items[{{ $i }}][batch]" class="js-example-basic-single select2 batch_dropdown" required>
                                                                <option value="">Select Batch</option>
                                                                @php
                                                                    $rawValue = old("items.$i.product", 'var_' .$requisition->items[$i]->product_variation_id ?? '');
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
                                                                            {{ old("items.$i.batch", $requisition->items[$i]->batch_id) == $batch->id ? 'selected' : '' }}>
                                                                            {{ $batch->batch_no }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    @elseif ($requisition->is_production == '1')
                                                        <div class="mb-3 col-md-4">
                                                            <label for="">Raw Material</label>
                                                            <select name="items[{{ $i }}][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required>
                                                                <option value="">Select Raw Material</option>
                                                                @php
                                                                    $seletedCompanyId = old('company', $requisition->company_id) ?? auth()->user()->employee->company_id;
                                                                @endphp
                                                                @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                                                    <option value="{{ $rawMaterialItem->id }}"
                                                                        {{ old("items.$i.raw_material_item", $requisition->items[$i]->raw_material_item_id) == $rawMaterialItem->id ? 'selected' : '' }}>
                                                                        {{ $rawMaterialItem->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="mb-3 col-md-4">
                                                        <label>Unit Price</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control w-25 unit_price" name="items[{{ $i }}][unit_price]"
                                                                placeholder="Unit Price" required value="{{ old("items.$i.unit_price", $requisition->items[$i]->unit_price) }}" oninput="calculateSingleProductAmount()">
                                                            <input type="text" class="form-control unit" name="items[{{ $i }}][unit]"
                                                                placeholder="Unit" required value="{{ old("items.$i.unit", $requisition->items[$i]->unit) }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 {{ $requisition->is_general == '1' ? 'col-md-4' : 'col-md-2'; }}">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control quantity" name="items[{{ $i }}][quantity]"
                                                            placeholder="Quantity" required value="{{ old("items.$i.quantity", $requisition->items[$i]->quantity) }}" oninput="calculateSingleProductAmount()">
                                                    </div>
                                                    <div class="mb-3 {{ $requisition->is_general == '1' ? 'col-md-4' : 'col-md-2'; }}">
                                                        <label>Total</label>
                                                        <input type="number" class="form-control product_total" name="items[{{ $i }}][total]"
                                                            placeholder="Total" required value="{{ old("items.$i.total", $requisition->items[$i]->total) }}" readonly>
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
                            <div class="mb-3 col-md-4">
                                @if ($requisition->is_general == '1')
                                    <label for="">Product</label>
                                    <select name="items[${ itemIndex }][product]" class="js-example-basic-single select2 products_dropdown" onchange="selectBatchesForProducts(this.value, this)" required></select>
                                @elseif ($requisition->is_production == '1')
                                    <label for="">Raw Material</label>
                                    <select name="items[${ itemIndex }][raw_material_item]" class="js-example-basic-single select2 raw_material_items_dropdown" required></select>
                                @endif
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control w-25 unit_price" name="items[${ itemIndex }][unit_price]"
                                        placeholder="Unit Price" required value="{{ old("items.$i.unit_price") }}" oninput="calculateSingleProductAmount()">
                                    <input type="text" class="form-control unit" name="items[${ itemIndex }][unit]"
                                        placeholder="Unit" required value="{{ old("items.$i.unit") }}">
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
            @if ($requisition->is_general == '1')
                // Clone the options from the first dropdown and append to the new dropdown
                const firstDropdownOptions = $(".products_dropdown:first").children().clone();
                $(`#item-group .item-set:last .products_dropdown`).append(firstDropdownOptions);
            @elseif ($requisition->is_production == '1')
                // Clone the options from the first dropdown and append to the new dropdown
                const firstDropdownOptions = $(".raw_material_items_dropdown:first").children().clone();
                $(`#item-group .item-set:last .raw_material_items_dropdown`).append(firstDropdownOptions);
            @endif
            
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