@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Salary Tax Slabs List</h4>
            <h6>Manage your salary tax slabs</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('tax-slabs.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Salary Tax Slab
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
                            <th>Slab Start</th>
                            <th>Slab End</th>
                            <th>Tax Value</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taxSlabs as $slab)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $slab->slab_start }}</td>
                                <td>{{ $slab->slab_end }}</td>
                                <td>{{ $slab->tax_value }}%</td>
                                @role('Superadmin')
                                <td>{{ $slab->company->name }}</td>
                                @endrole
                                <td class="text-center">
                                    <a class="me-3" href="{{ route('tax-slabs.edit', $slab->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <form action="{{ route('tax-slabs.destroy', $slab->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this tax slab?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-0 btn btn-link">
                                            <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                        </button>
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
