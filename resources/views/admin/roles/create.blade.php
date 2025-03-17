@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Role</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">roles</a></li>
                    <li class="breadcrumb-item active">Add Role</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" class="form-control" name="guard_name" value="web">
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" required>
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
                                        <td><input class="form-check-input" type="checkbox" value="16" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="17" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="18" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="19" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="20" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Batch</td>
                                        <td><input class="form-check-input" type="checkbox" value="146" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="147" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="148" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="149" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="140" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input class="form-check-input" type="checkbox" value="66" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="67" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="68" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="69" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="70" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td><input class="form-check-input" type="checkbox" value="101" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="102" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="103" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="104" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="105" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Chart Of Accounts</td>
                                        <td><input class="form-check-input" type="checkbox" value="56" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="57" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="58" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="59" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="60" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Cities</td>
                                        <td><input class="form-check-input" type="checkbox" value="41" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="42" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="43" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="44" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="45" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Companies</td>
                                        <td><input class="form-check-input" type="checkbox" value="46" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="47" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="48" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="49" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="50" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Countries</td>
                                        <td><input class="form-check-input" type="checkbox" value="36" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="37" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="38" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="39" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="40" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="206" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="207" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="208" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="209" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="210" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Departments</td>
                                        <td><input class="form-check-input" type="checkbox" value="51" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="52" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="53" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="54" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="55" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Designation</td>
                                        <td><input class="form-check-input" type="checkbox" value="71" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="72" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="73" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="74" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="75" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Dosage Form</td>
                                        <td><input class="form-check-input" type="checkbox" value="121" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="122" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="123" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="124" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="125" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Employee</td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="4" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="5" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Finished Goods Receiving</td>
                                        <td><input class="form-check-input" type="checkbox" value="176" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="177" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="178" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="179" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="180" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Franchises</td>
                                        <td><input class="form-check-input" type="checkbox" value="96" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="97" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="98" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="99" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="100" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Goods Receiving</td>
                                        <td><input class="form-check-input" type="checkbox" value="171" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="172" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="173" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="174" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="175" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice</td>
                                        <td><input class="form-check-input" type="checkbox" value="166" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="167" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="168" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="169" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="170" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Journal Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="216" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="217" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="218" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="219" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="220" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Leave</td>
                                        <td><input class="form-check-input" type="checkbox" value="6" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="7" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="8" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="9" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="10" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Leave Type</td>
                                        <td><input class="form-check-input" type="checkbox" value="11" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="12" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="13" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="14" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="15" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Left Over Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="191" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="192" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="193" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="194" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="195" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Loan</td>
                                        <td><input class="form-check-input" type="checkbox" value="26" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="27" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="28" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="29" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="30" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Pack Form</td>
                                        <td><input class="form-check-input" type="checkbox" value="136" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="137" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="138" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="139" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="140" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Pack Size</td>
                                        <td><input class="form-check-input" type="checkbox" value="111" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="112" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="113" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="114" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="115" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Packing Type</td>
                                        <td><input class="form-check-input" type="checkbox" value="106" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="107" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="108" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="109" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="110" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Parties</td>
                                        <td><input class="form-check-input" type="checkbox" value="31" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="32" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="33" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="34" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="35" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Types</td>
                                        <td><input class="form-check-input" type="checkbox" value="61" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="62" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="63" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="64" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="65" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="196" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="197" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="198" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="199" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="200" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Product</td>
                                        <td><input class="form-check-input" type="checkbox" value="126" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="127" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="128" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="129" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="130" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Product Group</td>
                                        <td><input class="form-check-input" type="checkbox" value="131" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="132" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="133" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="134" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="135" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Product Variation</td>
                                        <td><input class="form-check-input" type="checkbox" value="141" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="142" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="143" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="144" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="145" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Purchase Requisition</td>
                                        <td><input class="form-check-input" type="checkbox" value="161" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="162" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="163" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="164" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="165" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Raw Material Item</td>
                                        <td><input class="form-check-input" type="checkbox" value="151" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="152" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="153" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="154" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="155" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Receipt Voucher</td>
                                        <td><input class="form-check-input" type="checkbox" value="201" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="202" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="203" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="204" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="205" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Rejection Return Note</td>
                                        <td><input class="form-check-input" type="checkbox" value="186" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="187" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="188" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="189" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="190" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Roles</td>
                                        <td><input class="form-check-input" type="checkbox" value="81" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="82" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="83" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="84" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="85" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Salaries</td>
                                        <td><input class="form-check-input" type="checkbox" value="21" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="22" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="23" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="24" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="25" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Salary Tax Slabs</td>
                                        <td><input class="form-check-input" type="checkbox" value="76" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="77" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="78" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="79" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="80" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Sales Return List</td>
                                        <td><input class="form-check-input" type="checkbox" value="211" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="212" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="213" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="214" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="215" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Stock</td>
                                        <td><input class="form-check-input" type="checkbox" value="156" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="157" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="158" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="159" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="160" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Store Issue Rquisition</td>
                                        <td><input class="form-check-input" type="checkbox" value="181" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="182" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="183" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="184" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="185" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Suppliers</td>
                                        <td><input class="form-check-input" type="checkbox" value="91" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="92" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="93" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="94" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="95" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td><input class="form-check-input" type="checkbox" value="116" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="117" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="118" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="119" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="120" name="permissions[]" id="permissions"></td>
                                    </tr>
                                    <tr>
                                        <td>Users</td>
                                        <td><input class="form-check-input" type="checkbox" value="86" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="87" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="88" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="89" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="90" name="permissions[]" id="permissions"></td>
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
                                        <td><input class="form-check-input" type="checkbox" value="221" name="permissions[]" id="permissions"></td>
                                        <td><input class="form-check-input" type="checkbox" value="222" name="permissions[]" id="permissions"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Document Approvals</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input class="form-check-input" type="checkbox" value="223" name="permissions[]" id="permissions"></td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
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