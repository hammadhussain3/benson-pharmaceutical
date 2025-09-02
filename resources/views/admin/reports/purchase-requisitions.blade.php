@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Purchase Order Appraisal</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Purchase Order Appraisal</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Purchase Order Appraisal</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.purchase-order-appraisal') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>

    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-0">List of {{ $status == null ? 'All' : $status }} Purchase Order Appraisal</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            
            <!-- Filters Information for Print -->
            <div class="filters-info text-center mb-3" style="font-size: 12px; color: #666;">
                <strong>Filters Applied:</strong>
                @if($status || $from_date || $to_date)
                    <span class="filter-tags">
                        @if($status)
                            <span class="badge bg-primary me-1">Status: {{ $status }}</span>
                        @endif
                        @if($from_date)
                            <span class="badge bg-info me-1">From: {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }}</span>
                        @endif
                        @if($to_date)
                            <span class="badge bg-info me-1">To: {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</span>
                        @endif
                    </span>
                @else
                    <span class="text-muted">No filters applied</span>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>DOC NO.</th>
                            <th>Date</th>
                            <th>Req Del Date</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseRequisitions as $purchaseRequisitions)
                            <tr>
                                <td><a class="link-primary" href="{{ route('purchase-invoices.show', $purchaseRequisitions->id) }}">{{ $purchaseRequisitions->code }}</a></td>
                                <td>{{ \Carbon\Carbon::parse($purchaseRequisitions->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseRequisitions->required_date)->format('d M, Y') }}</td>
                                <td>{{ $purchaseRequisitions->status }}</td>
                                <td>
                                    @foreach ($purchaseRequisitions->items as $item)
                                        {!! $item->item_code. ' ' .$item->item_name. '<br>QTY=' .$item->quantity. ' RECV=' .$item->received_quantity !!}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>

    <script>
        function printWithTimestamp() {
            // Add timestamp to footer before printing
            const timestampContainer = document.getElementById('printTimestampContainer');
            
            if (timestampContainer) {
                const timestampDiv = document.createElement('div');
                timestampDiv.id = 'printTimestamp';
                timestampDiv.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
                timestampDiv.innerHTML = '<strong>Printed on:</strong> ' + new Date().toLocaleString('en-GB');
                
                // Clear any existing timestamp and add new one
                timestampContainer.innerHTML = '';
                timestampContainer.appendChild(timestampDiv);
            }
            
            // Small delay to ensure DOM is updated before printing
            setTimeout(() => {
                // Print
                window.print();
                
                // Remove timestamp after printing
                setTimeout(() => {
                    if (timestampContainer) {
                        timestampContainer.innerHTML = '';
                    }
                }, 2000);
            }, 100);
        }
    </script>
@endsection

<style>
    @media print {
       @page {
           margin: 0;
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
       .card-body *,
       #printTimestampContainer,
       #printTimestamp {
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
       
       /* Ensure timestamp container is visible in print */
       #printTimestampContainer {
           visibility: visible !important;
           display: block !important;
           page-break-inside: avoid !important;
       }
       
       #printTimestamp {
           visibility: visible !important;
           display: block !important;
           text-align: center !important;
           margin-top: 20px !important;
           font-size: 14px !important;
           color: #666 !important;
           page-break-inside: avoid !important;
       }
   }   
</style>