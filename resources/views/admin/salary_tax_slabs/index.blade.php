@extends('admin.layouts.app')

@section('title', 'Salary Tax Slabs List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Salary Tax Slabs List</h4>
            <h6>Manage your salary tax slabs</h6>
        </div>
        @if(auth()->user()->hasPermission('Salary Tax Slabs Create'))
        <div class="page-btn">
            <a href="{{ route('tax-slabs.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Salary Tax Slab
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
                            <th>Slab Start</th>
                            <th>Slab End</th>
                            <th>Tax Value</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Salary Tax Slabs View') || auth()->user()->hasPermission('Salary Tax Slabs Update') || auth()->user()->hasPermission('Salary Tax Slabs Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taxSlabs as $slab)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ number_format($slab->slab_start, 2) }}</td>
                                <td>{{ number_format($slab->slab_end, 2) }}</td>
                                <td>{{ $slab->tax_value }}%</td>
                                @role('Superadmin')
                                <td>{{ $slab->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Salary Tax Slabs View') || auth()->user()->hasPermission('Salary Tax Slabs Update') || auth()->user()->hasPermission('Salary Tax Slabs Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Salary Tax Slabs View'))
                                    <a class="me-3" href="{{ route('tax-slabs.view', $slab->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Salary Tax Slabs Update'))
                                    <a class="me-3" href="{{ route('tax-slabs.edit', $slab->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Salary Tax Slabs Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $slab->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $slab->id }}"
                                        action="{{ route('tax-slabs.destroy', $slab->id) }}" method="POST"
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