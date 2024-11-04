@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">User Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">user</a></li>
                    <li class="breadcrumb-item active">User Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="col-md-6 mb-3">
                            <label>Employee</label>
                            <input type="text" class="form-control" value="{{ $user->employee->code }} - {{ $user->employee->first_name }} {{ $user->employee->last_name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Role</label>
                            <input type="text" class="form-control" value="{{ $user->roles[0]->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="{{ $user->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $user->email ?? 'N/A' }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="col-md-6 mb-3">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ App\Models\Company::where('id', $user->employee->company_id)->value('name') ?? 'N/A' }}" readonly>
                        </div>
                        @endrole
                        <div class="col-md-6 mb-3">
                            <label>Branch</label>
                            <input type="text" class="form-control" value="{{ App\Models\Branch::where('id', $user->employee->branch_id)->value('name') ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Department</label>
                            <input type="text" class="form-control" value="{{ App\Models\Department::where('id', $user->employee->department_id)->value('name') ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Designation</label>
                            <input type="text" class="form-control" value="{{ App\Models\Designation::where('id', $user->employee->designation_id)->value('name') ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Update</a>
                            <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $user->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $user->id }}"
                                action="{{ route('users.destroy', $user->id) }}" method="POST"
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