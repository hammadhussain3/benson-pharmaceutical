@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Sub Category</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sub-categories.index') }}">Sub Categories</a></li>
                    <li class="breadcrumb-item active">Edit Sub Category</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sub-categories.update', $subCategory->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="category_id">Category</label>
                                <select class="js-example-basic-single select2" name="category" required>
                                    <option value="">Select Catgeory</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="prefix">Prefix</label>
                                <input type="text" class="form-control" name="prefix" id="prefix"
                                    value="{{ old('prefix', $subCategory->prefix) }}" placeholder="Prefix" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $subCategory->name) }}" placeholder="Name" required>
                            </div>
                            
                            <div class="mb-3 col-md-12">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description...">{{ old('description', $subCategory->description) }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('sub-categories.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection