<?php

namespace App\Services;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Spatie\QueryBuilder\QueryBuilder;

class SectionService
{
    private const DEFAULT_PER_PAGE = 10;

    public function getSections($request)
    {
        $sections = QueryBuilder::for(Section::class)
            ->allowedFilters('name')
            ->allowedSorts('name');

        return $sections->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
            ->appends($request->query());
    }

    public function getSection(Section $section): Section
    {
        $section->load([
            'articles' => function ($query) {
                $query->with(['file', 'category', 'municipality.department']);
            },
        ]);

        return $section;
    }

    public function createSection(StoreSectionRequest $request): Section
    {
        $section = new Section();

        $section->name = $request->name;

        $section->save();

        return $section;
    }

    public function updateSection(UpdateSectionRequest $request, Section $section): Section
    {
        $section->name = $request->name;

        $section->save();

        return $section;
    }

    public function deleteSection(Section $section): void
    {
        $section->delete();
    }
}
