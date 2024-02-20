<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = Section::all();

        return response()->json($section);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->all());

        return response()->json($section, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($section)
    {
        $section = Section::where('id', $section)
            ->orWhere('name', $section)
            ->firstOrFail();

        $section->load([
            'articles' => function ($query) {
                $query->with(['file', 'category', 'municipality.department']);
            },
        ]);

        return response()->json(new SectionResource($section));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->all());

        return response()->json($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json(null, 204);
    }
}
