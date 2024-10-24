<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function createRole(array $data, array $permissions)
    {
        $role = Role::create($data);
        $role->permissions()->sync($permissions); // Sync permissions with the role

        return $role;
    }

    // In your RoleService or controller
    public function updateRole(Role $role, array $data, array $permissions)
    {
        // Check if the name is unique (if not already handled by validation)
        if (Role::where('name', $data['name'])->where('id', '!=', $role->id)->exists()) {
            throw new \Exception('The role name is already taken.');
        }

        $role->update($data);
        $role->permissions()->sync($permissions); // Sync permissions with the role
        return $role;
    }

    public function deleteRole(Role $role)
    {
        // Detach all related permissions
        $role->permissions()->detach();

        // Delete the role
        return $role->delete();
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }
}