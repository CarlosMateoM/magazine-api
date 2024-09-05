<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Http\Resources\MunicipalityResource;
use App\Models\Municipality;
use App\Services\MunicipalityService;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{


    public function __construct(
        private MunicipalityService $municipalityService
    ) {
        $this->authorizeResource(Municipality::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $municipalities = $this->municipalityService->getMunicipalities($request);

        return response()->json(MunicipalityResource::collection($municipalities)->resource);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMunicipalityRequest $request)
    {
        $municipality = $this->municipalityService->createMunicipality($request);

        return response()->json(new MunicipalityResource($municipality), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Municipality $municipality)
    {
        return response()->json(new MunicipalityResource($municipality));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMunicipalityRequest $request, Municipality $municipality)
    {
        $municipality = $this->municipalityService->updateMunicipality($request, $municipality);

        return response()->json(new MunicipalityResource($municipality));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        $this->municipalityService->deleteMunicipality($municipality);

        return response()->json(['deleted_id' => $municipality->id], 204);
    }
}
