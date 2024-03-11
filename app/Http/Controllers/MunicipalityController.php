<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(Municipality::class)
                ->allowedFilters([
                    'department_id'
                ]);

        return response()->json($query->get()); 
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        //
    }
}
