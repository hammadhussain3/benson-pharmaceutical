@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Purchase Requisition List</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Purchase Requisition List</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Purchase Requisition List</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.purchase-requisitions') }}" class="row gy-2 gx-3 align-items-end" method="get">
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
            <h5 class="text-center card-title mb-0">List of {{ $status == null ? 'All' : $status }} Purchase Requisitions</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>PO#</th>
                            <th>Date</th>
                            <th>Req Del Date</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseRequisitions as $purchaseRequisitions)
                            <tr>
                                <td>{{ $purchaseRequisitions->code }}</td>
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