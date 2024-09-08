<?php

namespace App\Services;

use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class KeywordService
{

    private const DEFAULT_PER_PAGE = 10;


    public function getKeywords(Request $request)
    {
        $keywords = QueryBuilder::for(Keyword::class)
        ->allowedFilters('name');

        return $keywords->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
        ->appends($request->query());
    }

    public function getKeyword(Keyword $keyword): Keyword
    {
        return $keyword->load([
            'articles'
        ]);
    }

    public function createKeyword(StoreKeywordRequest $request): Keyword
    {
        $keyword = new Keyword();

        $keyword->name = $request->name;

        $keyword->save();

        return $keyword;
    }

    public function updateKeyword(UpdateKeywordRequest $request, Keyword $keyword): Keyword
    {
        $keyword->name = $request->name;

        $keyword->save();

        return $keyword;
    }

    public function deleteKeyword(Keyword $keyword): void
    {
        $keyword->delete();
    }
}   