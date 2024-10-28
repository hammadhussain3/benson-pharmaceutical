@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Salary List</h4>
            <h6>Manage your salaries</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('salary_slips.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Salary
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Approved Leave</th>
                            <th>Unauthorized Leave</th>
                            <th>Approved with Pay</th>
                            <th>Late/Early Out Deduction</th>
                            <th>Overtime</th>
                            <th>Arrears</th>
                            <th>Income Tax</th>
                            <th>Loan/Advance</th>
                            <th>Payment Mode</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salarySlips as $salarySlip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $salarySlip->employee->code }}</td>
                                <td>{{ $salarySlip->employee->first_name }} {{ $salarySlip->employee->last_name }}</td>
                                <td>{{ DateTime::createFromFormat('!m', $salarySlip->month)->format('F') }} {{ $salarySlip->year }}</td>
                                <td>{{ $salarySlip->auth_leave }}</td>
                                <td>{{ $salarySlip->unauth_leave }}</td>
                                <td>{{ $salarySlip->approved_with_pay }}</td>
                                <td>{{ $salarySlip->late_in_early_out_deduction }}</td>
                                <td>{{ $salarySlip->overtime }}</td>
                                <td>{{ $salarySlip->arrears }}</td>
                                <td>{{ $salarySlip->income_tax }}</td>
                                <td>{{ $salarySlip->loan_advance }}</td>
                                <td>{{ $salarySlip->payment_mode }}</td>
                                @role('Superadmin')
                                <td>{{ $salarySlip->company->name }}</td>
                                @endrole
                                <td class="text-center">
                                    <a class="me-3"
                                        href="{{ route('salary.sheet.show', ['employee_id' => $salarySlip->employee_id, 'month' => $salarySlip->year . '-' . str_pad($salarySlip->month, 2, '0', STR_PAD_LEFT)]) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    <a class="me-3" href="{{ route('salary_slips.edit', $salarySlip->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
                                        if (confirm('Are you sure you want to delete this salary slip?')) {
                                            document.getElementById('delete-form-{{ $salarySlip->id }}').submit();
                                        }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $salarySlip->id }}"
                                        action="{{ route('salary_slips.destroy', $salarySlip->id) }}" method="POST"
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
