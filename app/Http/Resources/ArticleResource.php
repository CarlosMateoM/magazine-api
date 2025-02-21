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
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'status'        => $this->status,
            'summary'       => $this->summary,
            'published_at'  => $this->published_at,
            'content'       => $this->content,
            'cover_image'   => new FileResource($this->whenLoaded('coverImage')),
            'author'        => new AuthorResource($this->whenLoaded('author')),
            'category'      => new CategoryResource($this->whenLoaded('category')),
            'municipality'  => new MunicipalityResource($this->whenLoaded('municipality')),
            'gallery'       => GalleryResource::collection($this->whenLoaded('galleries')),
            'sections'      => SectionResource::collection($this->whenLoaded('sections')),
            'keywords'      => KeywordResource::collection($this->whenLoaded('keywords')),
            'analitycs'     => [
                'views'     => $this->views
            ],
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];

        return $data;
    }
}