@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Parties List</h4>
            <h6>Manage your parties</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('parties.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Party
            </a>
        </div>
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
                            <th>Contact Person Name</th>
                            <th>Contact Person Phone</th>
                            <th>Contact Person Email</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Payment Type</th>
                            <th>Supplier</th>
                            <th>Distributor</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parties as $party)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $party->name }}</td>
                                <td>{{ $party->code }}</td>
                                <td>{{ $party->contact_person_name }}</td>
                                <td>{{ $party->contact_person_phone }}</td>
                                <td>{{ $party->contact_person_email }}</td>
                                <td>{{ $party->phone }}</td>
                                <td>{{ $party->email }}</td>
                                <td>{{ $party->country->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $party->city->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $party->address }}</td>
                                <td>{{ $party->paymentType->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $party->is_supplier ? 'Yes' : 'No' }}</td>
                                <td>{{ $party->is_distributor ? 'Yes' : 'No' }}</td>
                                @role('Superadmin')
                                <td>{{ $party->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td class="text-center">
                                    <a class="me-3" href="{{ route('parties.edit', $party->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
    if (confirm('Are you sure you want to delete this party?')) {
        document.getElementById('delete-form-{{ $party->id }}').submit();
    }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $party->id }}"
                                        action="{{ route('parties.destroy', $party->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
