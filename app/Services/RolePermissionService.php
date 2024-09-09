<?php 

namespace App\Services;

use App\Http\Requests\StoreRolePermissionRequest;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionService
{

    public function getPermissions(Role $role)
    {
        return $role->permissions;
    }

    public function attachPermissionsToRole(Role $role, StoreRolePermissionRequest $request): void
    {
        $role->permissions()->syncWithoutDetaching($request->input('permissionId'));
    }

    public function detachPermissionFromRole(Role $role, Permission $permission): void
    {
        $role->permissions()->detach($permission->id);
    }
}