<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RoleRequest;
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
        $roles = Role::with('permissions')->get(); // Get all roles
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role_has_permissions = DB::table('role_has_permissions')->where('role_id',$role->id)->get();
        return view('admin.roles.edit', compact('role', 'permissions', 'role_has_permissions'));
    }

    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $permissions = $request->input('permissions', []); // Get permission IDs from the request

        $this->roleService->createRole($data, $permissions);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->validated();
        $permissions = $request->input('permissions', []); // Get permission IDs from the request

        $this->roleService->updateRole($role, $data, $permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}