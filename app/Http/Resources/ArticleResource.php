<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' =>$this->status,
            'summary' => $this->summary,
            'views' => $this->views,
            'publishedAt' =>$this->published_at,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'municipality' => new MunicipalityResource($this->whenLoaded('municipality')),
            'image' => new FileResource($this->whenLoaded('file')), 
            'gallery' => GalleryResource::collection($this->whenLoaded('galleries')),
            'advertisements' => ArticleAdvertisementResource::collection($this->whenLoaded('advertisements')),
        ];

        if ($request->has('includeContent')) {
            $data['content'] = $this->content;
        }


        return $data;
    }
}