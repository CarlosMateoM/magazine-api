<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipalities = Municipality::all();

        return response()->json(['municipalities' => $municipalities]); 
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
