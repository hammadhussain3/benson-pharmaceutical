@extends('admin.layouts.app')

@section('title', 'Left Over Notes List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Left Over Note List</h4>
            <h6>Manage your Left Over Notes</h6>
        </div>
        @if(auth()->user()->hasPermission('Left Over Note Create'))
        <div class="page-btn">
            <a href="{{ route('left-over-notes.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Left Over Note
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
                    <thead class="thead">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Batch #</th>
                            <th>Department</th>
                            <th>DN/GP</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Left Over Note View') || auth()->user()->hasPermission('Left Over Note Update') || auth()->user()->hasPermission('Left Over Note Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leftOverNotes as $leftOverNote)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leftOverNote->code ?? 'N/A' }}</td>
                                <td>{{ $leftOverNote->product->name ?? 'N/A' }}</td>
                                <td>{{ $leftOverNote->batch->batch_no ?? 'N/A' }}</td>
                                <td>{{ $leftOverNote->department->name ?? 'N/A' }}</td>                                
                                <td>{{ $leftOverNote->storeIssueRequisition->dn_gp ?? 'N/A' }}</td>
                                @role('Superadmin')
                                    <td>{{ $leftOverNote->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td><span class="badge {{ $leftOverNote->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $leftOverNote->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Left Over Note View') || auth()->user()->hasPermission('Left Over Note Update') || auth()->user()->hasPermission('Left Over Note Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Left Over Note View'))
                                            <a class="me-3" href="{{ route('left-over-notes.show', $leftOverNote->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Left Over Note Update') && 
                                            ($leftOverNote->is_approved == 0 || ($leftOverNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('left-over-notes.edit', $leftOverNote->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Left Over Note Delete') && 
                                            ($leftOverNote->is_approved == 0 || ($leftOverNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $leftOverNote->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $leftOverNote->id }}"
                                                action="{{ route('left-over-notes.destroy', $leftOverNote->id) }}" method="POST"
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