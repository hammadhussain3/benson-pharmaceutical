@extends('admin.layouts.app')

@section('title', 'Pack Forms List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Pack Form List</h4>
            <h6>Manage your pack form</h6>
        </div>
        @if(auth()->user()->hasPermission('PackForm Create'))
        <div class="page-btn">
            <a href="{{ route('pack-forms.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Pack Form
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
                            @if(auth()->user()->hasPermission('PackForm Update'))
                            <th>Action</th>
                            @endif
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Description</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packForms as $packForm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('pack-forms.show', $packForm->id) }}">{{ $packForm->name }}</a></td>
                                @if(auth()->user()->hasPermission('PackForm Update'))
                                <td>
                                    <a class="me-3" href="{{ route('pack-forms.edit', $packForm->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                @role('Superadmin')
                                <td>{{ $packForm->company->name }}</td>
                                @endrole
                                <td>{{ $packForm->description }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
