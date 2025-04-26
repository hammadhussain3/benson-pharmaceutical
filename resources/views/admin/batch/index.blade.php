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
                            <th>Batch Size</th>
                            <th>Brand</th>
                            <th>MFG date</th>
                            <th>EXP date</th>
                            <th>Status</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Batch View') || auth()->user()->hasPermission('Batch Update') || auth()->user()->hasPermission('Batch Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('batches.show', $batch->id) }}">{{ $batch->batch_no }}</a></td>
                                <td>{{ $batch->batch_size }}</td>
                                <td>{{ $batch->product->brand_name }}</td>
                                <td>{{ $batch->mfg_date }}</td>
                                <td>{{ $batch->exp_date }}</td>
                                <td>
                                    <span class="badges {{ $batch->status == 'completed' ? 'bg-lightgreen' : 'bg-lightred' }}">
                                        {{ $batch->status == 'completed' ? 'Completed' : 'In-Process' }}
                                    </span>
                                </td>
                                @role('Superadmin')
                                <td>{{ $batch->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Batch View') || auth()->user()->hasPermission('Batch Update') || auth()->user()->hasPermission('Batch Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Batch View'))
                                    <a class="me-3" href="{{ route('batches.show', $batch->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Batch Update'))
                                    <a class="me-3" href="{{ route('batches.edit', $batch->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Batch Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $batch->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $batch->id }}"
                                        action="{{ route('batches.destroy', $batch->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
