@extends('admin.layouts.app')


@section('content')

    <div class="page-header">
        <div class="page-title">
            <h4>Credit Note List</h4>
            <h6>Manage your credit notes</h6>
        </div>
        @if(auth()->user()->hasPermission('Credit Note Create'))
        <div class="page-btn">
            <a href="{{ route('credit-notes.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Credit Note
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
                            <th>Date</th>
                            <th>Party</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Total</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Credit Note View') || auth()->user()->hasPermission('Credit Note Update') || auth()->user()->hasPermission('Credit Note Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditNotes as $creditNote)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('credit-notes.show', $creditNote->id) }}">{{ $creditNote->created_at->format('d M, Y') }}</a></td>
                                <td>{{ $creditNote->party->name }}</td>
                                <td>{{ $creditNote->party->address }}</td>
                                <td>{{ $creditNote->party->contact_person_name }}</td>
                                <td>{{ $creditNote->party->contact_person_phone ?? $creditNote->party->phone }}</td>
                                <td>{{ $creditNote->total }}</td>
                                @role('Superadmin')
                                    <td>{{ $creditNote->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Credit Note View') || auth()->user()->hasPermission('Credit Note Update') || auth()->user()->hasPermission('Credit Note Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Credit Note View'))
                                    <a class="me-3" href="{{ route('credit-notes.show', $creditNote->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Credit Note Update'))
                                    <a class="me-3" href="{{ route('credit-notes.edit', $creditNote->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Credit Note Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $creditNote->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $creditNote->id }}"
                                        action="{{ route('credit-notes.destroy', $creditNote->id) }}" method="POST"
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