<?php 

namespace App\Services;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest; 
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleService
{
    public function getRoles(Request $request)
    {
        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->allowedIncludes([
                'users',
                'permissions'
            ]);

        return $roles->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getRole(int $id): Role
    {
        $role = Role::with('permissions')->findOrFail($id);

        return $role;
    }

    public function createRole(StoreRoleRequest $request): Role
    {
        $role = new Role();

        $role->name = $request->name;

        $role->save();

        return $role;
    }

    public function updateRole(UpdateRoleRequest $request, Role $role): Role
    {
        $role->name = $request->name;

        $role->save();

        return $role;
    }

    public function deleteRole(Role $role): void
    {
        $role->delete();
    }

}