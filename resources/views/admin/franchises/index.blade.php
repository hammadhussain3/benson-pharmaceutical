@extends('admin.layouts.app')

@section('title', 'Customers List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Customer List</h4>
            <h6>Manage your Customers</h6>
        </div>
        @if(auth()->user()->hasPermission('Franchise Create'))
        <div class="page-btn">
            <a href="{{ route('franchises.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Customer
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
                            <th>DOC NO</th>
                            <th>Categories</th>
                            <th>Chart Of Accounts</th>
                            <th>Contact Person Name</th>
                            <th>Contact Person Contact</th>
                            <th>Contact</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Payment Type</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Franchise View') || auth()->user()->hasPermission('Franchise Update') || auth()->user()->hasPermission('Franchise Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($franchises as $franchise)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('franchises.show', $franchise->id) }}">{{ $franchise->name }}</a></td>
                                <td>{{ $franchise->code }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $franchise->category->name }}</span>
                                    @if ($franchise->subCategory)
                                        <span class="badge bg-info">{{ $franchise->subCategory->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $franchise->chart_of_account->particular ?? 'N/A' }}</span>
                                    @if ($franchise->sub_chart_of_account)
                                        <span class="badge bg-info">{{ $franchise->sub_chart_of_account->name }}</span>
                                    @endif
                                </td>
                                <td>{{ $franchise->contact_person_name }}</td>
                                <td>{{ $franchise->contact_person_email }}<br><span class="text-muted">{{ $franchise->contact_person_phone }}</span></td>
                                <td>{{ $franchise->email }}<br><span class="text-muted">{{ $franchise->phone }}</span></td>
                                <td>{{ $franchise->country->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $franchise->city->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $franchise->address }}</td>
                                <td>{{ $franchise->paymentType->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                @role('Superadmin')
                                <td>{{ $franchise->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Franchise View') || auth()->user()->hasPermission('Franchise Update') || auth()->user()->hasPermission('Franchise Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Franchise View'))
                                    <a class="me-3" href="{{ route('franchises.show', $franchise->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Franchise Update'))
                                    <a class="me-3" href="{{ route('franchises.edit', $franchise->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Franchise Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $franchise->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $franchise->id }}"
                                        action="{{ route('franchises.destroy', $franchise->id) }}" method="POST"
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