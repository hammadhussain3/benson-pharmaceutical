@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Payment Types List</h4>
            <h6>Manage your payment types</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('payment_types.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Payment Type
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
                            <th>Description</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentTypes as $paymentType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $paymentType->name }}</td>
                                <td>{{ $paymentType->description }}</td>
                                @role('Superadmin')
                                <td>{{ $paymentType->company->name }}</td>
                                @endrole
                                <td class="text-center">
                                    <a class="me-3" href="{{ route('payment_types.edit', $paymentType->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
    if (confirm('Are you sure you want to delete this payment type?')) {
        document.getElementById('delete-form-{{ $paymentType->id }}').submit();
    }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $paymentType->id }}"
                                        action="{{ route('payment_types.destroy', $paymentType->id) }}" method="POST"
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
