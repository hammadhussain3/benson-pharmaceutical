@extends('admin.layouts.app')

@section('title', 'Batches List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Batches List</h4>
            <h6>Manage your Batches</h6>
        </div>
        @if(auth()->user()->hasPermission('Batch Create'))
        <div class="page-btn">
            <a href="{{ route('batches.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Batch
            </a>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset">
                            <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Batch No</th>
                            @if(auth()->user()->hasPermission('Batch View') || auth()->user()->hasPermission('Batch Update') || auth()->user()->hasPermission('Batch Delete'))
                            <th>Action</th>
                            @endif
                            <th>Batch Size</th>
                            <th>Brand</th>
                            <th>Master Formulation</th>
                            <th>Chart Of Accounts</th>
                            <th>MFG date</th>
                            <th>EXP date</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Status</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> 
                                    @if(auth()->user()->hasPermission('Batch View'))
                                    <a class="link-primary" href="{{ route('batches.show', $batch->id) }}">{{ $batch->batch_no }}</a>
                                    @else
                                    {{ $batch->batch_no }}
                                    @endif
                                </td>
                                @if(auth()->user()->hasPermission('Batch View') || auth()->user()->hasPermission('Batch Update') || auth()->user()->hasPermission('Batch Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Batch Update'))
                                    <a class="me-3" href="{{ route('batches.edit', $batch->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $batch->batch_size }}</td>
                                <td>{{ $batch->product->brand_name }}</td>
                                <td>{{ $batch->masterFormulation->product_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $batch->chart_of_account->particular ?? 'N/A' }}</span>
                                    @if ($batch->sub_chart_of_account)
                                        <span class="badge bg-info">{{ $batch->sub_chart_of_account->name }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($batch->mfg_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($batch->exp_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($batch->start_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($batch->end_date)->format('d M, Y') }}</td>
                                <td>
                                    <span class="badges {{ $batch->status == 'completed' ? 'bg-whitegreen' : 'bg-whitered' }}">
                                        {{ $batch->status == 'completed' ? 'Completed' : 'In-Process' }}
                                    </span>
                                </td>
                                @role('Superadmin')
                                <td>{{ $batch->company->name }}</td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
