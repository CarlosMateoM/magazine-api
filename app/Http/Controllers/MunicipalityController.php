<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Municipality::class)
            ->allowedIncludes([
                'department'
            ])
            ->allowedFilters([
                'name',
                'department_id'
            ]);

        if ($request->has('paginate')) {
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
        $municipality = new Municipality();

        $municipality->name = $request->name;
        $municipality->department_id = $request->departmentId;

        $municipality->save();

        return response()->json($municipality, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Municipality $municipality)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMunicipalityRequest $request, Municipality $municipality)
    {
        $municipality->name = $request->name;
        $municipality->department_id = $request->departmentId;

        $municipality->save();

        return response()->json($municipality);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        //
    }
}
