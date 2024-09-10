<?php

namespace App\Services;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionService
{
    public function getPermissions(Request $request)
    {
        $permissions = QueryBuilder::for(Permission::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->allowedIncludes([
                'roles'
            ]);

        return $permissions->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getPermission(Permission $permission): Permission
    {
        return $permission->load([
            'roles'
        ]);
    }


    public function createPermission(StorePermissionRequest $request): Permission
    {
        $permission = new Permission();

        $permission->name = $request->name;

        $permission->save();

        return $permission;
    }

    public function updatePermission(UpdatePermissionRequest $request, Permission $permission): Permission
    {
        $permission->name = $request->name;

        $permission->save();

        return $permission;
    }

    public function deletePermission(Permission $permission): void
    {
        $permission->delete();
    }
}