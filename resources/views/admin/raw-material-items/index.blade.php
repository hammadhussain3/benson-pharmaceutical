@extends('admin.layouts.app')

@section('title', 'Raw Material Items List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Raw Material Item List</h4>
            <h6>Manage your Raw Material Items</h6>
        </div>
        @if(auth()->user()->hasPermission('Raw Material Item Create'))
        <div class="page-btn">
            <a href="{{ route('raw-material-items.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Raw Material Item
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Min. Level</th>
                            <th>Max. Level</th>
                            <th>Party</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Raw Material Item View') || auth()->user()->hasPermission('Raw Material Item Update') || auth()->user()->hasPermission('Raw Material Item Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rawMaterialItems as $rawMaterialItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('raw-material-items.show', $rawMaterialItem->id) }}">{{ $rawMaterialItem->code }}</a></td>
                                <td>{{ $rawMaterialItem->name }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ optional($rawMaterialItem->category)->name }}</span>
                                    @if ($rawMaterialItem->subCategory)
                                        <span class="badge bg-info">{{ $rawMaterialItem->subCategory->name }}</span>
                                    @endif
                                </td>
                                <td>{{ $rawMaterialItem->min_level }}</td>
                                <td>{{ $rawMaterialItem->max_level }}</td>
                                <td>
                                    {{ $rawMaterialItem->party ? $rawMaterialItem->party->name . ' (' . 
                                        ($rawMaterialItem->party->is_supplier == 1 ? 'Supplier' : 
                                        ($rawMaterialItem->party->is_distributor == 1 ? 'Franchiser' : '')) 
                                    . ')' : 'N/A' }}
                                </td>                                
                                @role('Superadmin')
                                <td>{{ $rawMaterialItem->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Raw Material Item View') || auth()->user()->hasPermission('Raw Material Item Update') || auth()->user()->hasPermission('Raw Material Item Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Raw Material Item View'))
                                    <a class="me-3" href="{{ route('raw-material-items.show', $rawMaterialItem->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Raw Material Item Update'))
                                    <a class="me-3" href="{{ route('raw-material-items.edit', $rawMaterialItem->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Raw Material Item Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $rawMaterialItem->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $rawMaterialItem->id }}"
                                        action="{{ route('raw-material-items.destroy', $rawMaterialItem->id) }}" method="POST"
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