<?php

namespace App\Services;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentService
{

    private const DEFAULT_PER_PAGE = 10;

    public function getDepartments(Request $request)
    {
        $departments = QueryBuilder::for(Department::class)
            ->allowedFilters('name')
            ->allowedIncludes('municipalities');

        return $departments->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
        ->appends($request->query());
    }

    public function getDepartment(Department $department): Department
    {
        $department->load([
            'municipalities'
        ]);

        return $department;
    }

    public function createDepartment(StoreDepartmentRequest $request): Department
    {
        $department = new Department();

        $department->name = $request->name;

        $department->save();

        return $department;
    }

    public function updateDepartment(UpdateDepartmentRequest $request, Department $department): Department
    {
        $department->name = $request->name;

        $department->save();

        return $department;
    }
   
    public function deleteDepartment(Department $department): void
    {
        $department->delete();
    }
}