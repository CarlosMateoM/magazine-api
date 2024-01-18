<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json(['departments' => $departments]);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $department = new Department();

        $department->name = $request->name;

        $department->save();

        return response()->json($department, 201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load([
            'municipalities'
        ]);

        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $departament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json(null, 204);
    }
}
