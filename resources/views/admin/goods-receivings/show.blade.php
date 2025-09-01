@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Goods Receiving Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('goods-receivings.index') }}">Goods Receiving Notes</a></li>
                <li class="breadcrumb-item active">View Goods Receiving Note</li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Previous Button --}}
            @if($previous)
                <a href="{{ route('goods-receivings.show', $previous->id) }}" class="btn btn-outline-secondary">
                    &laquo; Previous
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>&laquo; Previous</button>
            @endif

            {{-- Jump to Specific GRN Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="jumpToGRNDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Jump to GRN
                </button>
                <ul class="dropdown-menu" aria-labelledby="jumpToGRNDropdown" style="max-height: 300px; overflow-y: auto; min-width: 300px;">
                    <li class="px-3 py-2">
                        <input type="text" class="form-control form-control-sm" id="grnSearchInput" placeholder="Search GRN code or date..." onkeyup="filterGRNs()" oninput="filterGRNs()">
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach($allGRNs as $grn)
                        <li>
                            <a class="dropdown-item grn-item {{ $grn->id == $goodsReceiving->id ? 'active fw-bold' : '' }}" 
                               href="{{ route('goods-receivings.show', $grn->id) }}"
                               data-grn-code="{{ strtolower($grn->code) }}"
                               data-grn-date="{{ $grn->created_at->format('d/m/Y') }}">
                                <span>{{ $grn->code }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Next Button --}}
            @if($next)
                <a href="{{ route('goods-receivings.show', $next->id) }}" class="btn btn-outline-secondary">
                    Next &raquo;
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>Next &raquo;</button>
            @endif

            {{-- Print Button --}}
            <button class="btn btn-light" onclick="printWithTimestamp()" data-approved="{{ $goodsReceiving->is_approved }}" id="print-button">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Print">
            </button>
        </div>
    </div>

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($goodsReceiving->company->logo_path ? 'images/company/' . $goodsReceiving->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $goodsReceiving->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $goodsReceiving->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $goodsReceiving->company->phone }}</p>
                            @if($goodsReceiving->company->email)
                                <p class="fs-6 mb-0">{{ $goodsReceiving->company->email }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2>Goods Receiving Note</h2>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="width: 233px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Ref No:</strong> {{ $goodsReceiving->code }}</li>
                            <li class="list-group-item"><strong>PO Date:</strong> {{ $goodsReceiving->created_at->format('d M, Y') }}</li>
                        </ul>
                    </div>
                </div>
                <div style="width: 766px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>PO Ref:</strong> {{ $goodsReceiving->invoice->code }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>Supplier:</strong> {{ $goodsReceiving->supplier_name }}
                                    </div>
                                    <div class="col border-start border-end"><strong>Supplier Code</strong></div>
                                    <div class="col d-flex align-items-center">
                                        {{ $goodsReceiving->supplier_code }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>Required Date:</strong> {{ $goodsReceiving->invoice->required_date ? \Carbon\Carbon::parse($goodsReceiving->invoice->required_date)->format('d M, Y') : 'N/A' }}
                                    </div>
                                    <div class="col border-start border-end"><strong>Urgent</strong></div>
                                    <div class="col d-flex align-items-center">
                                        {!! $goodsReceiving->invoice->is_urgent == '1' ? '<i class="fa fa-check"></i>' : '' !!}
                                    </div>
                                    <div class="col border-start border-end"><strong>Ordinary</strong></div>
                                    <div class="col">{{ $goodsReceiving->invoice->is_urgent == '0' ? '*' : '' }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead class="table-header-custom">
                        <tr class="border-bottom">
                            <th class="border-end align-middle text-center" rowspan="2">#</th>
                            <th class="border-end align-middle text-center" rowspan="2">Code</th>
                            <th class="border-end align-middle text-center" rowspan="2" style="width: 30%">Description</th>
                            <th class="border-end text-center" colspan="3">Quantity</th>
                            <th class="border-end align-middle text-center" rowspan="2">Unit</th>
                            <th class="border-end text-center" colspan="2">Price (Rs.)</th>
                            <th class="border-end text-center" colspan="2">Last Purchase</th>
                        </tr>
                        <tr class="border-bottom">
                            <th class="border-end text-center">Ordered</th>
                            <th class="border-end text-center">Pending</th>
                            <th class="border-end text-center">Received</th>
                            <th class="border-end text-center">Per Unit</th>
                            <th class="text-center">Total</th>
                            <th class="border-end text-center">Ref.</th>
                            <th class="text-center">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goodsReceiving->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td class="description-cell">
                                    Batch# {{ $item->batch }}<br>
                                    MFG: {{ $item->mfg_date ? \Carbon\Carbon::parse($item->mfg_date)->format('d/m/Y') : 'N/A' }}<br>
                                    EXP: {{ $item->exp_date ? \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') : 'N/A' }}<br>
                                    {{ $item->description }}
                                </td>
                                <td>{{ $item->quantity_ordered }}</td>
                                <td>{{ max(0, $item->quantity_ordered - ($item->quantity_received + $item->balance_receivable)) }}</td>
                                <td>{{ $item->quantity_received + $item->balance_receivable }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_amount, 2) }}</td>
                                <td>{{ $item->last_goods_receiving ? $item->last_goods_receiving->goodsReceiving->code : 'N/A' }}</td>
                                <td>{{ $item->last_goods_receiving ? number_format($item->last_goods_receiving->unit_price, 2) : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="10" class="text-end"><strong>Total</strong></th>
                            <td>{{ number_format($goodsReceiving->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($goodsReceiving->note)
                <div style="width: 100%;">
                    <div style="margin-bottom: 15px; margin-top: 15px; font-size: 14px;">
                        <strong>Note:</strong> {{ $goodsReceiving->note }}
                    </div>
                </div>
            @endif

            <!-- Vendor Bills Summary -->
            @if(isset($goodsReceiving->vendor_bills) && count($goodsReceiving->vendor_bills) > 0)
                <div style="width: 100%; margin-top: 15px;">
                    <div style="margin-bottom: 15px; margin-top: 15px; font-size: 14px;">
                        <strong>Vendor Bills Summary:</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Vendor Bill No</th>
                                    <th>Bill Date</th>
                                    <th>Amount (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($goodsReceiving->vendor_bills as $vendorBill)
                                    <tr>
                                        <td>
                                            @if(isset($goodsReceiving->items[$vendorBill->item_index]))
                                                {{ Str::limit($goodsReceiving->items[$vendorBill->item_index]->description, 50) }}
                                            @else
                                                Item {{ $vendorBill->item_index + 1 }}
                                            @endif
                                        </td>
                                        <td>{{ $vendorBill->bill_no }}</td>
                                        <td>{{ $vendorBill->bill_date ? \Carbon\Carbon::parse($vendorBill->bill_date)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ number_format($vendorBill->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end"><strong>Total Vendor Bills Amount:</strong></th>
                                    <th>{{ number_format($goodsReceiving->vendor_bills->sum('amount'), 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif

            <div class="signature-section" style="margin-top: 45px;">
                <div style="display: flex; justify-content: space-around; align-items: end;">
                    <div style="width: 200px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">{{ $goodsReceiving->createdBy->name ?? null }}</span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Raised by</span>
                    </div>
                    <div style="width: 200px; text-align: center;">
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Received by</span>
                    </div>
                    <div style="width: 200px; text-align: center;">
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Accepted by</span>
                    </div>
                    <div style="width: 200px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">
                            @if($goodsReceiving->is_approved == 1)
                                Approved
                            @else
                                Draft
                            @endif
                        </span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Approved by</span>
                    </div>
                </div>
            </div>
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>
@endsection

<style>
    .print-header {
        margin-top: 10px !important;
    }

    /* Custom table header styling to match the image */
    .table-header-custom th {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6 !important;
    }
    
    .table-header-custom th:hover {
        background-color: #e9ecef !important;
    }

    /* Ensure long descriptions wrap inside the cell */
    .table.table-bordered td.description-cell {
        white-space: normal !important;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    /* Stronger borders for the items grid */
    .table.table-bordered {
        border-collapse: collapse;
    }
    
    .table.table-bordered th,
    .table.table-bordered td {
        border: 1px solid #dee2e6 !important;
    }

    @media print {
        .signature-section {
            position: fixed;
            bottom: 10px;
            left: 0;
            width: 100%;
        }

        @page {
            margin: 0;
            size: landscape;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body * {
            visibility: hidden;
        }

        .card-body,
        .card-body * {
            visibility: visible;
        }

        .card-body {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
        }

        .table-primary th {
            background-color: transparent !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        table.table-bordered {
            font-size: 10px !important;
        }

        .approved-target {
            background-color: transparent !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .print-header {
            margin-top: 15px !important;
        }

        /* Hide dropdown in print */
        .dropdown {
            display: none !important;
        }

        /* Darker borders on print for clarity */
        .table.table-bordered th,
        .table.table-bordered td {
            border: 1px solid #000 !important;
        }
    }
</style>

<script>
    function printWithTimestamp() {
        // Add timestamp to footer before printing
        const timestampContainer = document.getElementById('printTimestampContainer');
        const timestampDiv = document.createElement('div');
        timestampDiv.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
        timestampDiv.innerHTML = '<strong>Printed on:</strong> ' + new Date().toLocaleString('en-GB');
        
        // Clear any existing timestamp and add new one
        timestampContainer.innerHTML = '';
        timestampContainer.appendChild(timestampDiv);
        
        // Print
        window.print();
        
        // Remove timestamp after printing
        setTimeout(() => {
            timestampContainer.innerHTML = '';
        }, 1000);
    }

    // Clear search when dropdown is closed
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('jumpToGRNDropdown');
        const searchInput = document.getElementById('grnSearchInput');
        
        dropdown.addEventListener('hidden.bs.dropdown', function() {
            searchInput.value = '';
            filterGRNs(); // Reset the filter
        });
    });

    function filterGRNs() {
        console.log('filterGRNs function called');
        const searchInput = document.getElementById('grnSearchInput');
        const searchTerm = searchInput.value.toLowerCase().trim();
        const grnItems = document.querySelectorAll('.grn-item');
        
        console.log('Search term:', searchTerm);
        console.log('Found GRN items:', grnItems.length);
        
        if (searchTerm === '') {
            // Show all items if search is empty
            grnItems.forEach(item => {
                item.style.display = '';
            });
            console.log('Showing all items');
            return;
        }

        let hasResults = false;
        
        grnItems.forEach((item, index) => {
            const grnCode = item.dataset.grnCode || '';
            const grnDate = item.dataset.grnDate || '';
            const itemText = item.textContent.toLowerCase();
            
            console.log(`Item ${index}:`, { grnCode, grnDate, itemText });
            
            const isMatch = grnCode.includes(searchTerm) || 
                           grnDate.includes(searchTerm) || 
                           itemText.includes(searchTerm);
            
            if (isMatch) {
                item.style.display = '';
                hasResults = true;
                console.log(`Item ${index} matches, showing`);
            } else {
                item.style.display = 'none';
                console.log(`Item ${index} doesn't match, hiding`);
            }
        });

        console.log('Has results:', hasResults);

        // Show/hide no results message
        let noResultsMsg = document.querySelector('.no-results-msg');
        if (!hasResults && searchTerm.length > 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('li');
                noResultsMsg.className = 'dropdown-item text-muted text-center no-results-msg';
                noResultsMsg.textContent = 'No GRNs found matching your search';
                document.querySelector('.dropdown-menu').appendChild(noResultsMsg);
                console.log('Added no results message');
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
            console.log('Removed no results message');
        }
    }
</script>