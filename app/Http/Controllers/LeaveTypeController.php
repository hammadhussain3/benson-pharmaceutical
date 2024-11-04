<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveTypeRequest;
use App\Models\Company;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.leave_types.index', compact('leaveTypes'));
    }

    public function view($id)
    {
        $leave_type =  LeaveType::findorfail($id);
        return view('admin.leave_types.view', compact('leave_type'));
    }

    public function create()
    {
        $companies = Company::all(); // Assuming you have a Company model
        return view('admin.leave_types.create', compact('companies'));
    }

    public function store(StoreLeaveTypeRequest $request)
    {
        $data = [
            'name' => $request->name,
            'company_id' => $request->company
        ];
        LeaveType::create($data);
        return redirect()->route('leave_types.index')->with('success', 'Leave Type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        $companies = Company::all();
        return view('admin.leave_types.edit', compact('leaveType', 'companies'));
    }

    public function update(StoreLeaveTypeRequest $request, LeaveType $leaveType)
    {
        $data = [
            'name' => $request->name,
            'company_id' => $request->company
        ];
        $leaveType->update($data);
        return redirect()->route('leave_types.index')->with('success', 'Leave Type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return redirect()->route('leave_types.index')->with('success', 'Leave Type deleted successfully.');
    }
}