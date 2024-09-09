<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Http\Resources\KeywordResource;
use App\Models\Keyword;
use App\Services\KeywordService;
use Illuminate\Http\Request;

class KeywordController extends Controller
{

    public function __construct(
        private KeywordService $keywordService
    ) {
        $this->authorizeResource(Keyword::class, 'keyword');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $this->keywordService->getKeywords($request);

        return KeywordResource::collection($keywords)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKeywordRequest $request)
    {
        $keyword = $this->keywordService->createKeyword($request);

        return new KeywordResource($keyword);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        $keyword = $this->keywordService->getKeyword($keyword);

        return new KeywordResource($keyword);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeywordRequest $request, Keyword $keyword)
    {
        $keyword = $this->keywordService->updateKeyword($request, $keyword);

        return new KeywordResource($keyword);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        $this->keywordService->deleteKeyword($keyword);

        return response()->noContent();
    }
}
