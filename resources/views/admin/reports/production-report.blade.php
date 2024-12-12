@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Production Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Production Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Production Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.production-report') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-4 col-md-3">
                <label class="form-label" for="year">Select Year</label>
                <select class="form-select" id="year" name="year">
                    @php 
                        $currentYear = date('Y');
                        $startYear = $currentYear - 25;
                        for ($yearOption = $currentYear; $yearOption >= $startYear; $yearOption--) {
                            $selected = (isset($year) && $year == $yearOption) ? 'selected' : '';
                            echo "<option value=\"$yearOption\" $selected>$yearOption</option>";
                        }
                    @endphp
                </select>
            </div> 
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>

    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-0">Production Report</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($year)->startOfYear()->format('d M, Y') }} to {{ \Carbon\Carbon::create($year)->endOfYear()->format('d M, Y') }}</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Item</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>Aug</th>
                            <th>Sept</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productionReport as $production)
                            <tr>
                                <td>{{ $production->product->name. ' | ' .$production->packingType->name. ' | ' .$production->packSize->name }}</td>
                                @foreach ($production->monthly_totals as $month => $total)
                                    <td>{{ $total }}</td>
                                @endforeach
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
            size: landscape;
        }

        body {
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .card {
            border: none;
            margin: 0;
        }

        .table-primary th {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            
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
           font-size: 11px;
       }

       .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
</style>