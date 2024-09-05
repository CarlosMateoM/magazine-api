<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function __construct(
        private DepartmentService $departmentService
    )
    {
        $this->authorizeResource(Department::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = $this->departmentService->getDepartments($request);
        
        return response()->json(DepartmentResource::collection($departments)->resource);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->departmentService->createDepartment($request);

        return response()->json(new DepartmentResource($department), 201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department = $this->departmentService->getDepartment($department);

        return response()->json(new DepartmentResource($department));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department = $this->departmentService->updateDepartment($request, $department);

        return response()->json(new DepartmentResource($department));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->departmentService->deleteDepartment($department);

        return response()->json(['deleted_id' => $department->id], 204);
    }
}
