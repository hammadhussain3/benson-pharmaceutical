@extends('admin.layouts.app')

@section('title', 'Credit Notes List')

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
                            <th>DOC NO</th>
                            @if(auth()->user()->hasPermission('Credit Note Update'))
                            <th>Action</th>
                            @endif
                            <th>Party</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Date</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditNotes as $creditNote)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('credit-notes.show', $creditNote->id) }}">{{ $creditNote->code }}</a></td>
                                @if(auth()->user()->hasPermission('Credit Note Update'))
                                <td>
                                    @if($creditNote->is_approved == 0 || ($creditNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    <a class="me-3" href="{{ route('credit-notes.edit', $creditNote->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $creditNote->party->name }}</td>
                                <td>{{ $creditNote->party->address }}</td>
                                <td>{{ $creditNote->party->contact_person_name }}</td>
                                <td>{{ $creditNote->party->contact_person_phone ?? $creditNote->party->phone }}</td>
                                <td>{{ $creditNote->total }}</td>
                                <td>{{ $creditNote->created_at->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $creditNote->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $creditNote->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $creditNote->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection