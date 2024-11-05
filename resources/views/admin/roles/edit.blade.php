@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Role</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="form-control" name="guard_name" value="web">
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $role->name) }}" required>
                                <div class="invalid-feedback">Please provide a unique role.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions" onclick="toggleAll(this)">
                                <label class="form-check-label" for="selectAllPermissions">
                                    Administration
                                </label>
                            </div>
                            <div class="invalid-feedback">Please provide a unique role.</div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Modules</th>
                                        <th>List</th>
                                        <th>create</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Employee</td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(1) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(2) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(3) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="4" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(4) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="5" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(5) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Leave</td>
                                        <td><input class="form-check-input" type="checkbox" value="6" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(6) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="7" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(7) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="8" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(8) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="9" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(9) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="10" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(10) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Leave Type</td>
                                        <td><input class="form-check-input" type="checkbox" value="11" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(11) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="12" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(12) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="13" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(13) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="14" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(14) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="15" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(15) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Bank</td>
                                        <td><input class="form-check-input" type="checkbox" value="16" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(16) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="17" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(17) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="18" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(18) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="19" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(19) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="20" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(20) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Salaries</td>
                                        <td><input class="form-check-input" type="checkbox" value="21" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(21) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="22" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(22) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="23" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(23) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="24" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(24) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="25" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(25) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Loan</td>
                                        <td><input class="form-check-input" type="checkbox" value="26" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(26) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="27" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(27) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="28" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(28) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="29" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(29) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="30" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(30) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Parties</td>
                                        <td><input class="form-check-input" type="checkbox" value="31" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(31) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="32" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(32) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="33" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(33) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="34" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(34) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="35" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(35) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Countries</td>
                                        <td><input class="form-check-input" type="checkbox" value="36" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(36) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="37" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(37) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="38" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(38) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="39" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(39) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="40" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(40) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Cities</td>
                                        <td><input class="form-check-input" type="checkbox" value="41" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(41) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="42" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(42) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="43" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(43) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="44" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(44) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="45" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(45) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Companies</td>
                                        <td><input class="form-check-input" type="checkbox" value="46" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(46) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="47" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(47) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="48" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(48) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="49" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(49) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="50" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(50) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Departments</td>
                                        <td><input class="form-check-input" type="checkbox" value="51" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(51) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="52" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(52) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="53" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(53) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="54" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(54) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="55" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(55) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Chart Of Accounts</td>
                                        <td><input class="form-check-input" type="checkbox" value="56" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(56) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="57" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(57) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="58" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(58) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="59" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(59) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="60" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(60) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Types</td>
                                        <td><input class="form-check-input" type="checkbox" value="61" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(61) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="62" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(62) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="63" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(63) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="64" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(64) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="65" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(65) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input class="form-check-input" type="checkbox" value="66" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(66) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="67" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(67) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="68" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(68) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="69" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(69) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="70" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(70) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Designation</td>
                                        <td><input class="form-check-input" type="checkbox" value="71" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(71) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="72" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(72) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="73" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(73) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="74" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(74) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="75" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(75) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Salary Tax Slabs</td>
                                        <td><input class="form-check-input" type="checkbox" value="76" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(76) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="77" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(77) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="78" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(78) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="79" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(79) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="80" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(80) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Roles</td>
                                        <td><input class="form-check-input" type="checkbox" value="81" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(81) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="82" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(82) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="83" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(83) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="84" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(84) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="85" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(85) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Users</td>
                                        <td><input class="form-check-input" type="checkbox" value="86" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(86) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="87" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(87) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="88" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(88) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="89" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(89) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="90" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(90) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Suppliers</td>
                                        <td><input class="form-check-input" type="checkbox" value="91" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(91) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="92" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(92) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="93" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(93) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="94" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(94) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="95" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(95) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Franchises</td>
                                        <td><input class="form-check-input" type="checkbox" value="96" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(96) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="97" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(97) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="98" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(98) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="99" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(99) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="100" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(100) ? 'checked' : '' }}></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAll(selectAll) {
            // Get all checkboxes in the table
            const checkboxes = document.querySelectorAll('table input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked; // Set each checkbox to the state of the "Select All" checkbox
            });
        }
    </script> 
@endsection