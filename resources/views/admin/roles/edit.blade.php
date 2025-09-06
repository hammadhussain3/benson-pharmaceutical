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
                                        <td>Bank</td>
                                        <td><input class="form-check-input" type="checkbox" value="16" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(16) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="17" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(17) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="18" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(18) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="19" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(19) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="20" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(20) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Batch</td>
                                        <td><input class="form-check-input" type="checkbox" value="146" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(146) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="147" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(147) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="148" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(148) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="149" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(149) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="150" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(150) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input class="form-check-input" type="checkbox" value="66" name="permissions[]" id="permissions_66" {{ $role_has_permissions->pluck('permission_id')->contains(66) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="67" name="permissions[]" id="permissions_67" {{ $role_has_permissions->pluck('permission_id')->contains(67) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="68" name="permissions[]" id="permissions_68" {{ $role_has_permissions->pluck('permission_id')->contains(68) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="69" name="permissions[]" id="permissions_69" {{ $role_has_permissions->pluck('permission_id')->contains(69) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="70" name="permissions[]" id="permissions_70" {{ $role_has_permissions->pluck('permission_id')->contains(70) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td><input class="form-check-input" type="checkbox" value="126" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(126) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="127" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(127) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="128" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(128) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="129" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(129) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="130" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(130) ? 'checked' : '' }}></td>
                                    </tr>                                    
                                    <tr>
                                        <td>Categories</td>
                                        <td><input class="form-check-input" type="checkbox" value="101" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(101) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="102" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(102) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="103" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(103) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="104" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(104) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="105" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(105) ? 'checked' : '' }}></td>
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
                                        <td>Countries</td>
                                        <td><input class="form-check-input" type="checkbox" value="36" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(36) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="37" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(37) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="38" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(38) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="39" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(39) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="40" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(40) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="206" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(206) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="207" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(207) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="208" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(208) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="209" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(209) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="210" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(210) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Customers</td>
                                        <td><input class="form-check-input" type="checkbox" value="96" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(96) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="97" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(97) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="98" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(98) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="99" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(99) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="100" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(100) ? 'checked' : '' }}></td>
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
                                        <td>Designation</td>
                                        <td><input class="form-check-input" type="checkbox" value="71" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(71) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="72" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(72) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="73" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(73) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="74" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(74) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="75" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(75) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Dosage Form</td>
                                        <td><input class="form-check-input" type="checkbox" value="121" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(121) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="122" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(122) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="123" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(123) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="124" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(124) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="125" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(125) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Employee</td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(1) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(2) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(3) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="4" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(4) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="5" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(5) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Employee Type</td>
                                        <td><input class="form-check-input" type="checkbox" value="224" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(224) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="225" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(225) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="226" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(226) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="227" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(227) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="228" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(228) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Finished Goods Receiving</td>
                                        <td><input class="form-check-input" type="checkbox" value="176" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(176) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="177" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(177) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="178" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(178) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="179" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(179) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="180" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(180) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Goods Receiving</td>
                                        <td><input class="form-check-input" type="checkbox" value="171" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(171) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="172" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(172) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="173" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(173) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="174" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(174) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="175" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(175) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Journal Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="216" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(216) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="217" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(217) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="218" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(218) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="219" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(219) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="220" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(220) ? 'checked' : '' }}></td>
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
                                        <td>Left Over Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="191" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(191) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="192" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(192) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="193" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(193) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="194" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(194) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="195" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(195) ? 'checked' : '' }}></td>
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
                                        <td>Manual Purchase Requisition</td>
                                        <td><input class="form-check-input" type="checkbox" value="161" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(161) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="162" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(162) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="163" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(163) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="164" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(164) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="165" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(165) ? 'checked' : '' }}></td>
                                    </tr>
                                
                                    <tr>
                                        <td>Pack Form</td>
                                        <td><input class="form-check-input" type="checkbox" value="136" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(136) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="137" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(137) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="138" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(138) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="139" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(139) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="140" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(140) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Pack Size</td>
                                        <td><input class="form-check-input" type="checkbox" value="111" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(111) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="112" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(112) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="113" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(113) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="114" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(114) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="115" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(115) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Packing Type</td>
                                        <td><input class="form-check-input" type="checkbox" value="106" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(106) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="107" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(107) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="108" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(108) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="109" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(109) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="110" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(110) ? 'checked' : '' }}></td>
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
                                        <td>Payment Types</td>
                                        <td><input class="form-check-input" type="checkbox" value="61" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(61) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="62" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(62) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="63" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(63) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="64" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(64) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="65" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(65) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="196" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(196) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="197" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(197) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="198" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(198) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="199" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(199) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="200" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(200) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Product</td>
                                        <td><input class="form-check-input" type="checkbox" value="141" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(141) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="142" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(142) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="143" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(143) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="144" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(144) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="145" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(145) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Product Group</td>
                                        <td><input class="form-check-input" type="checkbox" value="131" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(131) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="132" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(132) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="133" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(133) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="134" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(134) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="135" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(135) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Purchase Requisition</td>
                                        <td><input class="form-check-input" type="checkbox" value="229" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(229) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="230" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(230) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="231" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(231) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="232" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(232) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="233" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(233) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Raw Material Item</td>
                                        <td><input class="form-check-input" type="checkbox" value="151" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(151) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="152" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(152) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="153" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(153) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="154" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(154) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="155" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(155) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Receipt Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="201" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(201) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="202" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(202) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="203" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(203) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="204" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(204) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="205" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(205) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Rejection Return Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="186" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(186) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="187" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(187) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="188" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(188) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="189" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(189) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="190" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(190) ? 'checked' : '' }}></td>
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
                                        <td>Salaries</td>
                                        <td><input class="form-check-input" type="checkbox" value="21" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(21) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="22" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(22) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="23" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(23) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="24" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(24) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="25" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(25) ? 'checked' : '' }}></td>
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
                                        <td>Sale Invoice</td>
                                        <td><input class="form-check-input" type="checkbox" value="166" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(166) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="167" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(167) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="168" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(168) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="169" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(169) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="170" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(170) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Sales Return List</td>
                                        <td><input class="form-check-input" type="checkbox" value="211" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(211) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="212" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(212) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="213" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(213) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="214" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(214) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="215" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(215) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Sale Warranties</td>
                                        <td><input class="form-check-input" type="checkbox" value="234" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(234) ? 'checked' : '' }}></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input class="form-check-input" type="checkbox" value="235" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(235) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Stock</td>
                                        <td><input class="form-check-input" type="checkbox" value="156" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(156) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="157" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(157) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="158" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(158) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="159" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(159) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="160" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(160) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Store Issue Rquisition</td>
                                        <td><input class="form-check-input" type="checkbox" value="181" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(181) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="182" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(182) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="183" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(183) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="184" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(184) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="185" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(185) ? 'checked' : '' }}></td>
                                    </tr>
                                    <tr>
                                        <td>Sub-Categories</td>
                                        <td><input class="form-check-input" type="checkbox" value="236" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(236) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="237" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(237) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="238" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(238) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="239" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(239) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="240" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(240) ? 'checked' : '' }}></td>
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
                                        <td>Tax</td>
                                        <td><input class="form-check-input" type="checkbox" value="116" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(116) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="117" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(117) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="118" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(118) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="119" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(119) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="120" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(120) ? 'checked' : '' }}></td>
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
                                        <td>Master Formulation</td>
                                        <td><input class="form-check-input" type="checkbox" value="242" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(242) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="243" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(243) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="244" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(244) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="245" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(245) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="246" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(246) ? 'checked' : '' }}></td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <th colspan="6" class="text-center">Approvals</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Approved Document</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input class="form-check-input" type="checkbox" value="221" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(221) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="222" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(222) ? 'checked' : '' }}></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Document Approvals</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input class="form-check-input" type="checkbox" value="223" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(223) ? 'checked' : '' }}></td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input class="form-check-input" type="checkbox" value="241" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(241) ? 'checked' : '' }}></td>
                                        <td>-</td>
                                        <td>-</td>
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