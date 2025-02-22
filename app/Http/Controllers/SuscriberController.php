<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuscriberRequest;
use App\Http\Requests\UpdateSuscriberRequest;
use App\Models\Suscriber;
use App\Services\SuscriberService;

class SuscriberController extends Controller
{

    public function __construct(
        private SuscriberService $suscriberService
    )
    {
     
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuscriberRequest $request)
    {   
        $this->suscriberService->create($request->validated());
        
        return response()->json(['message' => 'Suscripción exitosa'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Suscriber $suscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suscriber $suscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuscriberRequest $request, Suscriber $suscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suscriber $suscriber)
    {
        //
    }
}
