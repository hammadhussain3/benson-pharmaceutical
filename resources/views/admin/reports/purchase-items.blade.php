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
            <button class="btn btn-primary" onclick="window.print()">Print Purchase Requisition List</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.purchase-items') }}" class="row gy-2 gx-3 align-items-end" method="get">
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
            <h5 class="text-center card-title mb-0">List of {{ $status == null ? 'All' : $status }} Purchase Requisition Items</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>PO#</th>
                            <th>Date</th>
                            <th>Req Del Date</th>
                            <th>Status</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Qty Ord</th>
                            <th>Qty Rec</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseItems as $purchaseItem)
                            <tr>
                                <td>{{ $purchaseItem->invoice->code }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseItem->invoice->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseItem->invoice->required_date)->format('d M, Y') }}</td>
                                <td>{{ $purchaseItem->status }}</td>
                                <td>{{ $purchaseItem->item_code }}</td>
                                <td>{{ $purchaseItem->product->name ?? $purchaseItem->rawMaterialItem->name }}</td>
                                <td>{{ $purchaseItem->product_quantity }}</td>
                                <td>{{ $purchaseItem->received_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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