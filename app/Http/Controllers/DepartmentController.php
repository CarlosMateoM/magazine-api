<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Department::class)
            ->allowedIncludes([
                'municipalities'
            ])
            ->allowedFilters([
                'name'
            ]);

        if($request->has('paginate')){
            $result = $query->paginate($request->paginate);
        } else {
            $result = $query->get();
        }
        
        return response()->json($result);
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
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->name = $request->name;
        $department->save();

        return response()->json($department);
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
