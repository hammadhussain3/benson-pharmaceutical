<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Models\Company;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Employee; // Assuming you have an Employee model
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        $leaves = Leave::with(['employee', 'leaveType'])->get();
        return view('admin.leaves.index', compact('leaves', 'companies'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::all();
        $employees = Employee::all();
        $companies = Company::all();
        return view('admin.leaves.create', compact('leaveTypes', 'employees', 'companies'));
    }

    public function store(StoreLeaveRequest $request)
    {
        Leave::create($request->validated());
        return redirect()->route('leaves.index')->with('success', 'Leave created successfully.');
    }

    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $leaveTypes = LeaveType::all();
        $employees = Employee::all();
        $companies = Company::all();
        return view('admin.leaves.edit', compact('leave', 'leaveTypes', 'employees', 'companies'));
    }


    public function update(StoreLeaveRequest $request, $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update($request->validated());
        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }

    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }

    public function getApprovedLeavesByEmployee($employeeId)
    {
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',1)->first();
        return response()->json(['leaves' => $leaves]);
    }
    public function getUnauthorizedLeavesByEmployee($employeeId)
    {
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',2)->first();
        return response()->json(['leaves' => $leaves]);
    }
    public function getApprovedWithPayLeavesByEmployee($employeeId)
    {
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',3)->first();
        return response()->json(['leaves' => $leaves]);
    }
}
