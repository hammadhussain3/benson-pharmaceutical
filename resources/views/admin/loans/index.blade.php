@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Loans List</h4>
            <h6>Manage your loans</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('loans.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Loan
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
                            <th>Employee</th>
                            <th>Amount</th>
                            <th>Payback Months</th>
                            <th>Remaining</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->employee->first_name }}
                                    {{ $loan->employee->last_name }}</td>
                                <td>{{ number_format($loan->amount, 2) }}</td>
                                <td>{{ $loan->payback_months }}</td>
                                <td>{{ $loan->remaining }}</td>
                                @role('Superadmin')
                                <td>{{ $loan->company->name }}</td>
                                @endrole
                                <td>{{ \Carbon\Carbon::parse($loan->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <a class="me-3" href="{{ route('loans.edit', $loan->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
    if (confirm('Are you sure you want to delete this loan?')) {
        document.getElementById('delete-form-{{ $loan->id }}').submit();
    }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $loan->id }}"
                                        action="{{ route('loans.destroy', $loan->id) }}" method="POST"
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
