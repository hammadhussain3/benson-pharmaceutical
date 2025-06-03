@extends('admin.layouts.app')

@section('title', 'Suppliers List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Supplier List</h4>
            <h6>Manage your Suppliers</h6>
        </div>
        @if(auth()->user()->hasPermission('Supplier Create'))
        <div class="page-btn">
            <a href="{{ route('suppliers.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Supplier
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Chart Of Accounts</th>
                            <th>Contact Person Name</th>
                            <th>Contact Person Phone</th>
                            <th>Contact Person Email</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Payment Type</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Supplier View') || auth()->user()->hasPermission('Supplier Update') || auth()->user()->hasPermission('Supplier Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('suppliers.show', $supplier->id) }}">{{ $supplier->name }}</a></td>
                                <td>{{ $supplier->code }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $supplier->chart_of_account->particular ?? 'N/A' }}</span>
                                    @if ($supplier->sub_chart_of_account)
                                        <span class="badge bg-info">{{ $supplier->sub_chart_of_account->name }}</span>
                                    @endif
                                </td>
                                <td>{{ $supplier->contact_person_name }}</td>
                                <td>{{ $supplier->contact_person_phone }}</td>
                                <td>{{ $supplier->contact_person_email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->country->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $supplier->city->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $supplier->address }}</td>
                                <td>{{ $supplier->paymentType->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                @role('Superadmin')
                                <td>{{ $supplier->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Supplier View') || auth()->user()->hasPermission('Supplier Update') || auth()->user()->hasPermission('Supplier Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Supplier View'))
                                    <a class="me-3" href="{{ route('suppliers.show', $supplier->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Supplier Update'))
                                    <a class="me-3" href="{{ route('suppliers.edit', $supplier->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Supplier Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $supplier->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $supplier->id }}"
                                        action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
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