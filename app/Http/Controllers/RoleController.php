<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\EditRoleRequest;
use App\Services\RoleService;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Roles List')) {
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::with('permissions')->where('name', '!=', 'Superadmin')->orderBy('name', 'asc')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Roles View')) {
            abort(403, 'Unauthorized action.');
        }
        $role =  Role::findOrFail($id);
        return view('admin.roles.view', compact('role'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Roles Create')) {
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function edit(Role $role)
    {
        if (!auth()->user()->hasPermission('Roles Update')) {
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();
        $role_has_permissions = DB::table('role_has_permissions')->where('role_id',$role->id)->get();
        return view('admin.roles.edit', compact('role', 'permissions', 'role_has_permissions'));
    }

    public function store(AddRoleRequest $request)
    {
        if (!auth()->user()->hasPermission('Roles Create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validated();
        $permissions = $request->input('permissions', []); // Get permission IDs from the request

        $this->roleService->createRole($data, $permissions);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(EditRoleRequest $request, Role $role)
    {
        if (!auth()->user()->hasPermission('Roles Update')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validated();
        $permissions = $request->input('permissions', []); // Get permission IDs from the request

        $this->roleService->updateRole($role, $data, $permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (!auth()->user()->hasPermission('Roles Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->roleService->deleteRole($role);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}