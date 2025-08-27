@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Purchase Order List</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Reports</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print PO List</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.purchase-items') }}" class="row gy-2 gx-3 align-items-end" method="get">
            {{-- <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div> --}}
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Partial" {{ $status == 'Partial' ? 'selected' : '' }}>Partial</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label for="days_filter">Days</label>
                <select name="days_filter" id="days_filter" class="form-select">
                    <option value="">Select</option>
                    <option value="overdue" {{ $days_filter == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="remaining" {{ $days_filter == 'remaining' ? 'selected' : '' }}>Remaining</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label for="urgent">Urgent</label>
                <select name="urgent" id="urgent" class="form-select">
                    <option value="">Select</option>
                    <option value="1" {{ $urgent == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $urgent == '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="type">Report Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Select Type</option>
                    <option value="purchase-order" {{ $type == 'purchase-order' ? 'selected' : '' }}>Purchase Order</option>
                    <option value="items-name" {{ $type == 'items-name' ? 'selected' : '' }}>Items Name</option>
                    <option value="vendor" {{ $type == 'vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="req-date" {{ $type == 'req-date' ? 'selected' : '' }}>Req. Date</option>
                    <option value="days-remaining" {{ $type == 'days-remaining' ? 'selected' : '' }}>Days Remaining</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>

    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-0">{{ $status == null ? 'All' : $status }} PO Report</h5>
            <p class="text-center text-muted mb-0">
                {{ $type ? ucwords(str_replace('-', ' ', $type)) : ucwords(str_replace('-', ' ', 'purchase-order')) }} Wise
            </p>
            
            <!-- Filters Information for Print -->
            <div class="filters-info text-center mb-3" style="font-size: 12px; color: #666;">
                <strong>Filters Applied:</strong>
                @if($status || $days_filter || $urgent !== null || $type)
                    <span class="filter-tags">
                        @if($status)
                            <span class="badge bg-primary me-1">Status: {{ $status }}</span>
                        @endif
                        @if($days_filter)
                            <span class="badge bg-info me-1">Days: {{ ucfirst($days_filter) }}</span>
                        @endif
                        @if($urgent !== null)
                            <span class="badge bg-warning me-1">Urgent: {{ $urgent == '1' ? 'Yes' : 'No' }}</span>
                        @endif
                        @if($type)
                            <span class="badge bg-secondary me-1">Type: {{ ucwords(str_replace('-', ' ', $type)) }}</span>
                        @endif
                    </span>
                @else
                    <span class="text-muted">No filters applied</span>
                @endif
            </div>
            {{-- <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p> --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>DOC NO.</th>
                            <th>Items Name</th>
                            <th>Vendor</th>
                            <th>PO Date</th>
                            <th>Req Date</th>
                            <th>Days Remaining</th>
                            <th>Status</th>
                            <th>PO Qty</th>
                            <th>Pending Qty</th>
                            <th>Urgent</th>
                            {{-- <th>Date</th>
                            <th>Code</th> --}}
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseItems as $purchaseItem)
                            <tr>
                                <td><a class="link-primary" href="{{ route('purchase-invoices.show', $purchaseItem->invoice->id) }}">{{ $purchaseItem->invoice->code }}</a></td>
                                <td>{{ $purchaseItem->title }}</td>
                                <td>{{ $purchaseItem->invoice->party->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseItem->invoice->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseItem->invoice->required_date)->format('d M, Y') }}</td>
                                <td>
                                    @php
                                        $requiredDate = \Carbon\Carbon::parse($purchaseItem->invoice->required_date);
                                        $remainingDays = now()->startOfDay()->diffInDays($requiredDate->startOfDay(), false);
                                    @endphp
                                    <small class="">
                                        {{ $remainingDays < 0 ? abs($remainingDays) . ' days overdue' : $remainingDays . ' days left' }}
                                    </small>
                                </td>
                                <td>{{ $purchaseItem->status }}</td>
                                <td>{{ $purchaseItem->quantity }}</td>
                                <td>{{ $purchaseItem->quantity - $purchaseItem->received_quantity }}</td>
                                <td>{{ $purchaseItem->invoice->is_urgent === 1 ? 'Yes' : 'No' }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($purchaseItem->invoice->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ $purchaseItem->item_code }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>
@endsection

<style>
    @media print {
       @page {
           margin: 0;
           size: landscape;
       }
   
       html, body {
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
           background-color: #e3f2fd !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }
       
       /* Apply the same working table styles from show.blade.php */
       table.table {
           font-size: 10px !important;
       }
       
       /* Ensure all columns are visible with proper sizing */
       .table {
           width: 100% !important;
           table-layout: auto;
       }
       
       .table th, .table td {
           white-space: normal !important;
           word-wrap: break-word !important;
           padding: 4px 6px;
       }
       
       /* Force table-responsive to show all content */
       .table-responsive {
           overflow: visible !important;
           width: 100% !important;
       }
       
       /* Ensure filters information is visible in print */
       .filters-info {
           visibility: visible !important;
           display: block !important;
       }
       
       .filter-tags .badge {
           background-color: #e3f2fd !important;
           color: #1976d2 !important;
           border: 1px solid #bbdefb !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }
   }   
</style>