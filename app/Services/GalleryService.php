<?php

namespace App\Services;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use Spatie\QueryBuilder\QueryBuilder;

class GalleryService
{

    public function getGalleries($request)
    {
        $galleries = QueryBuilder::for(Gallery::class)
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

        return $galleries->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getGallery(Gallery $gallery): Gallery
    {
        $gallery->load('file', 'article');

        return $gallery;
    }

    public function createGallery(StoreGalleryRequest $request): Gallery
    {
        $gallery = new Gallery();
        
        $gallery->caption       = $request->caption;  
        $gallery->file_id       = $request->fileId;
        $gallery->article_id    = $request->articleId;

        $gallery->save();

        return $gallery;
    }

    public function updateGallery(UpdateGalleryRequest $request, Gallery $gallery): Gallery
    {
        $gallery->file_id = $request->fileId;
        $gallery->caption = $request->caption;
        $gallery->article_id = $request->articleId;

        return $gallery;
    }

    public function deleteGallery($gallery): void
    {
        $gallery->delete();
    }
}