<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\Role;
use App\Services\RolePermissionService;

class RolePermissionController extends Controller
{

    public function __construct(
        private RolePermissionService $rolePermissionService
    )
    {
        $this->authorizeResource(Role::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Role $role)
    {
        $permissions = $this->rolePermissionService->getPermissions($role);

        return PermissionResource::collection($permissions)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Role $role, StoreRolePermissionRequest $request)
    {
        $this->rolePermissionService->attachPermissionsToRole($role, $request);

        return response()->json(['message' => 'Permission attached to role successfully'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, Permission $permission)
    {
        $this->rolePermissionService->detachPermissionFromRole($role, $permission);

        return response()->noContent();
    }

}
