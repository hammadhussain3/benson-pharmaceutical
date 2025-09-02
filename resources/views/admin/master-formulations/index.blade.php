@extends('admin.layouts.app')

@section('title', 'Master Formulations List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Master Formulations List</h4>
            <h6>Manage your Master Formulations</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('master-formulations.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Master Formulation
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
                            <th>Product</th>
                            <th>Action</th>
                            <th>Batch Size</th>
                            <th>Product Quantity</th>
                            <th>Created At</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterFormulations as $masterFormulation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a class="link-primary" href="{{ route('master-formulations.show', $masterFormulation->id) }}">
                                        {{ $masterFormulation->product->brand_name }}
                                    </a>
                                </td>
                                <td>
                                    <a class="me-3" href="{{ route('master-formulations.show', $masterFormulation->id) }}" title="View">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    <a class="me-3" href="{{ route('master-formulations.edit', $masterFormulation->id) }}" title="Edit">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);" onclick="confirmDelete({{ $masterFormulation->id }})" title="Delete">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                </td>
                                <td>{{ $masterFormulation->batch_size }}</td>
                                <td>{{ $masterFormulation->product_quantity }}</td>
                                <td>{{ $masterFormulation->created_at->format('d M, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="delete-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this Master Formulation?')) {
            document.getElementById('delete-form').action = '{{ route("master-formulations.destroy", ":id") }}'.replace(':id', id);
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush
