<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\EmployeeService;

class LeaveController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Leave List')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::all();
        $leavesQuery = Leave::with(['employee', 'leaveType'])
            ->orderBy(Employee::select(DB::raw("CONCAT(first_name, ' ', last_name)"))
                ->whereColumn('employees.id', 'leaves.employee_id')
            );

        if (!auth()->user()->hasRole('Superadmin')) {
            $leavesQuery->where('company_id', auth()->user()->employee->company_id);
        }
    
        $leaves = $leavesQuery->get();
    
        return view('admin.leaves.index', compact('leaves', 'companies'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Leave View')) {
            abort(403, 'Unauthorized action.');
        }
        $leave = Leave::findOrFail($id);
        return view('admin.leaves.view', compact('leave'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Leave Create')) {
            abort(403, 'Unauthorized action.');
        }
        $leaveTypes = LeaveType::all();
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.leaves.create', compact('leaveTypes', 'employees', 'companies'));
    }

    public function store(StoreLeaveRequest $request)
    {
        if (!auth()->user()->hasPermission('Leave Create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = [
            'employee_id' => $request->employee,
            'company_id' => $request->company,
            'leave_type_id' => $request->leave_type,
            'days' => $request->days,
        ];
        Leave::create($data);
        return redirect()->route('leaves.index')->with('success', 'Leave created successfully.');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Leave Update')) {
            abort(403, 'Unauthorized action.');
        }
        $leave = Leave::findOrFail($id);
        $leaveTypes = LeaveType::all();
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.leaves.edit', compact('leave', 'leaveTypes', 'employees', 'companies'));
    }


    public function update(StoreLeaveRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Leave Update')) {
            abort(403, 'Unauthorized action.');
        }
        $leave = Leave::findOrFail($id);
        $data = [
            'employee_id' => $request->employee,
            'company_id' => $request->company,
            'leave_type_id' => $request->leave_type,
            'days' => $request->days,
        ];
        $leave->update($data);
        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Leave Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }

    public function getApprovedLeavesByEmployee($employeeId)
    {
        if (!auth()->user()->hasPermission('Leave List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',1)->first();
        return response()->json(['leaves' => $leaves]);
    }
    public function getUnauthorizedLeavesByEmployee($employeeId)
    {
        if (!auth()->user()->hasPermission('Leave List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',2)->first();
        return response()->json(['leaves' => $leaves]);
    }
    public function getApprovedWithPayLeavesByEmployee($employeeId)
    {
        if (!auth()->user()->hasPermission('Leave List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $leaves = Leave::where('employee_id',$employeeId)->where('leave_type_id',3)->first();
        return response()->json(['leaves' => $leaves]);
    }
}