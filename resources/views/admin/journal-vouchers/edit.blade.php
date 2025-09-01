@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Journal Voucher</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('journal-vouchers.index') }}">Journal Vouchers</a></li>
                    <li class="breadcrumb-item active">Edit Journal Voucher</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('journal-vouchers.update', $journalVoucher->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectChartOfAccounts(this.value); createJournalVoucherCode(this.value);">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $journalVoucher->company_id) == $company->id ? 'selected' : '' }}>
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
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $journalVoucher->code) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" name="year" id="year" placeholder="Year" value="{{ old('year', $journalVoucher->year) }}">
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 mb-0" id="item-group">
                                    @for ($i = 0; $i < count(old('items', $journalVoucher->items)); $i++)
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
                                                        <label for="">Chart Of Accounts</label>
                                                        <select name="items[{{ $i }}][chart_of_account]" class="js-example-basic-single select2 chart_of_accounts_dropdown" required>
                                                            <option value="">Select Chart Of Account</option>
                                                            @php
                                                                $seletedCompanyId = old('company', $journalVoucher->company_id) ?? auth()->user()->employee->company_id;
                                                            @endphp
                                                            @foreach ($charOfAccounts->where('company_id', $seletedCompanyId) as $charOfAccount)
                                                                <option value="{{ $charOfAccount->id }}"
                                                                    {{ old("items.$i.chart_of_account", $journalVoucher->items[$i]->chart_of_account_id) == $charOfAccount->id ? 'selected' : '' }}>
                                                                    {{ $charOfAccount->particular }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Debit</label>
                                                        <input type="number" class="form-control debit" name="items[{{ $i }}][debit]"
                                                            value="{{ old("items.$i.debit", $journalVoucher->items[$i]->debit) }}" oninput="calculateJournalVoucherAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label>Credit</label>
                                                        <input type="number" class="form-control credit" name="items[{{ $i }}][credit]"
                                                            value="{{ old("items.$i.credit", $journalVoucher->items[$i]->credit) }}" oninput="calculateJournalVoucherAmount()">
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="items[{{ $i }}][description]" id="description"
                                                            placeholder="Description...">{{ old("items.$i.description", $journalVoucher->items[$i]->description) }}</textarea>
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
                                <label for="total_debit">Total Debit</label>
                                <input type="number" class="form-control" name="total_debit" id="total_debit"
                                    value="{{ old('total_debit', $journalVoucher->total_debit) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total_credit">Total Credit</label>
                                <input type="number" class="form-control" name="total_credit" id="total_credit"
                                    value="{{ old('total_credit', $journalVoucher->total_credit) }}" readonly>
                            </div>                         
                        </div>
                        <a class="btn btn-secondary" href="{{ route('journal-vouchers.index') }}">Cancel</a>
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
                            <div class="mb-3 col-md-4">
                                <label for="">Chart Of Accounts</label>
                                <select name="items[${itemIndex}][chart_of_account]" class="js-example-basic-single select2 chart_of_accounts_dropdown" required>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Debit</label>
                                <input type="number" class="form-control debit" name="items[${itemIndex}][debit]"
                                    value="0" oninput="calculateJournalVoucherAmount()">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label>Credit</label>
                                <input type="number" class="form-control credit" name="items[${itemIndex}][credit]"
                                    value="0" oninput="calculateJournalVoucherAmount()">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="Description..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $("#item-group").append(html);
            // Clone the options from the first dropdown and append to the new dropdown
            const firstDropdownOptions = $(".chart_of_accounts_dropdown:first").children().clone();
            $(`#item-group .item-set:last .chart_of_accounts_dropdown`).append(firstDropdownOptions);
            itemIndex++;
            $('.js-example-basic-single').select2({});
        }

        function removeLastItem() {
            // Select all .item-set elements within #item-group
            const itemSets = document.querySelectorAll('#item-group .item-set');
            
            // Only remove if there is more than one item set
            if (itemSets.length > 1) {
                itemSets[itemSets.length - 1].remove(); // Remove the last added item set
                calculateJournalVoucherAmount();
                itemIndex--; // Decrement the index to keep track accurately
            }
        }
    </script>
@endsection