@extends('admin.layouts.app')

@section('title', 'Payment Types List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Payment Types List</h4>
            <h6>Manage your payment types</h6>
        </div>
        @if(auth()->user()->hasPermission('Payment Types Create'))
        <div class="page-btn">
            <a href="{{ route('payment_types.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Payment Type
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
                            <th>Description</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Payment Types View') || auth()->user()->hasPermission('Payment Types Update') || auth()->user()->hasPermission('Payment Types Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentTypes as $paymentType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('payment_types.view', $paymentType->id) }}">{{ $paymentType->name }}</a></td>
                                <td>{{ $paymentType->description }}</td>
                                @role('Superadmin')
                                <td>{{ $paymentType->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Payment Types View') || auth()->user()->hasPermission('Payment Types Update') || auth()->user()->hasPermission('Payment Types Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Payment Types View'))
                                    <a class="me-3" href="{{ route('payment_types.view', $paymentType->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Payment Types Update'))
                                    <a class="me-3" href="{{ route('payment_types.edit', $paymentType->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Payment Types Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $paymentType->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $paymentType->id }}"
                                        action="{{ route('payment_types.destroy', $paymentType->id) }}" method="POST"
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
