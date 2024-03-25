<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Spatie\QueryBuilder\QueryBuilder;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(Gallery::class)
            ->allowedFilters([
                'caption',
                'file.name',
                'article.id',
            ])
            ->allowedIncludes([
                'file',
                'article',
            ])
            ->allowedSorts([
                'caption',
                'created_at',
            ]);

        return response()->json(GalleryResource::collection($query->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $gallery = new Gallery();
        
        $gallery->file_id = $request->fileId;
        $gallery->caption = $request->caption;  
        $gallery->article_id = $request->articleId;

        $gallery->save();

        return response()->json(new GalleryResource($gallery), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load([
            'file',
            'article',  
        ]);

        return response()->json($gallery);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->file_id = $request->fileId;
        $gallery->caption = $request->caption;
        $gallery->article_id = $request->articleId;

        $gallery->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
    }
}
