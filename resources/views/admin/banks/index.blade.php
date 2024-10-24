@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Banks List</h4>
            <h6>Manage your banks</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('banks.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Bank
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
                <table id="example" class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank Name</th>
                            <th>Acronym</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banks as $bank)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank->name }}</td>
                                <td>{{ $bank->acronym }}</td>
                                <td>{{ $bank->country->name }}</td>
                                <td class="text-center">
                                    <a class="me-3" href="{{ route('banks.edit', $bank->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
                                      if (confirm('Are you sure you want to delete this bank?')) {
                                            document.getElementById('delete-form-{{ $bank->id }}').submit();
                                              }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $bank->id }}"
                                        action="{{ route('banks.destroy', $bank->id) }}" method="POST"
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
