@extends('admin.layouts.app')

@section('title', 'Salaries List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Salary List</h4>
            <h6>Manage your salaries</h6>
        </div>
        @if(auth()->user()->hasPermission('Salaries Create'))
        <div class="page-btn">
            <a href="{{ route('salary_slips.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Salary
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Late/Early Out Deduction</th>
                            <th>Overtime</th>
                            <th>Arrears</th>
                            <th>Income Tax</th>
                            <th>Loan/Advance</th>
                            <th>Payment Mode</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Salaries View') || auth()->user()->hasPermission('Salaries Update') || auth()->user()->hasPermission('Salaries Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salarySlips as $salarySlip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('salary.sheet.show', ['employee_id' => $salarySlip->employee_id, 'month' => $salarySlip->year . '-' . str_pad($salarySlip->month, 2, '0', STR_PAD_LEFT)]) }}">{{ $salarySlip->employee->code }}</a></td>
                                <td>{{ $salarySlip->employee->first_name }} {{ $salarySlip->employee->last_name }}</td>
                                <td>{{ DateTime::createFromFormat('!m', $salarySlip->month)->format('F') }} {{ $salarySlip->year }}</td>
                                <td>{{ $salarySlip->late_in_early_out_deduction }}</td>
                                <td>{{ $salarySlip->overtime }}</td>
                                <td>{{ $salarySlip->arrears }}</td>
                                <td>{{ number_format($salarySlip->income_tax, 2) }}</td>
                                <td>{{ number_format($salarySlip->loan_advance, 2) }}</td>
                                <td>{{ $salarySlip->payment_mode }}</td>
                                @role('Superadmin')
                                <td>{{ $salarySlip->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $salarySlip->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $salarySlip->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Salaries View') || auth()->user()->hasPermission('Salaries Update') || auth()->user()->hasPermission('Salaries Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Salaries View'))
                                    <a class="me-3" href="{{ route('salary.sheet.show', ['employee_id' => $salarySlip->employee_id, 'month' => $salarySlip->year . '-' . str_pad($salarySlip->month, 2, '0', STR_PAD_LEFT)]) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Salaries Update') && 
                                        ($salarySlip->is_approved == 0 || ($salarySlip->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="me-3" href="{{ route('salary_slips.edit', $salarySlip->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Salaries Delete') && 
                                        ($salarySlip->is_approved == 0 || ($salarySlip->is_approved == 1 && auth()->user()->hasPermission('Approved Document Delete')))
                                    )
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $salarySlip->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $salarySlip->id }}"
                                        action="{{ route('salary_slips.destroy', $salarySlip->id) }}" method="POST"
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
