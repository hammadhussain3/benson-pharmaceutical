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
                    <option value="left" {{ $days_filter == 'left' ? 'selected' : '' }}>Left</option>
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
                    <option value="pending-qty" {{ $type == 'pending-qty' ? 'selected' : '' }}>Pending Qty</option>
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
            {{-- <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p> --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>PO#</th>
                            <th>Items Name</th>
                            <th>Vendor</th>
                            <th>Req Date</th>
                            <th>Days Remaining</th>
                            <th>Status</th>
                            <th>PO Qty</th>
                            <th>Pedning Qty</th>
                            <th>Urgent</th>
                            {{-- <th>Date</th>
                            <th>Code</th> --}}
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseItems as $purchaseItem)
                            <tr>
                                <td>{{ $purchaseItem->invoice->code }}</td>
                                <td>{{ $purchaseItem->title }}</td>
                                <td>{{ $purchaseItem->invoice->party->name ?? 'N/A' }}</td>
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
   }   
</style>