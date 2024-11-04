@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">City Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Cities</a></li>
                    <li class="breadcrumb-item active">City Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">

                        <div class="mb-3 col-md-12">
                            <label>City Name</label>
                            <input type="text" class="form-control" value="{{ $city->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $city->country->name ?? 'N/A' }}" readonly>
                        </div>

                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="btn btn-primary" href="{{ route('cities.edit', $city->id) }}">Update</a>
                            <a class="btn btn-secondary" href="{{ route('cities.index') }}">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $city->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $city->id }}"
                                action="{{ route('cities.destroy', $city->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection