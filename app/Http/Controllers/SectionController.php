<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function __construct(
        private SectionService $sectionService
    )
    {
        $this->authorizeResource(Section::class, 'section');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sections = $this->sectionService->getSections($request);

        return SectionResource::collection($sections)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $section = $this->sectionService->createSection($request);

        return new SectionResource($section);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        $section = $this->sectionService->getSection($section);

        return new SectionResource($section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section = $this->sectionService->updateSection($request, $section);

        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $this->sectionService->deleteSection($section);

        return response()->noContent();
    }
}
