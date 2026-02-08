<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function __construct(
        private RoleService $roleService
    ) {
        //$this->authorizeResource(Role::class, 'role');
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->getRoles($request);

        return RoleResource::collection($roles)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole($request);

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $role = $this->roleService->getRole($id);

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $this->roleService->updateRole($request, $role);

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);

        return response()->noContent();
    }
}
