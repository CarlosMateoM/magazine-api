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
            'views'         => $this->views,
            'publishedAt'   => $this->published_at,
            'content'       => $this->content,
            'file'          => new FileResource($this->whenLoaded('file')),
            'user'          => new UserResource($this->whenLoaded('user')),
            'category'      => new CategoryResource($this->whenLoaded('category')),
            'municipality'  => new MunicipalityResource($this->whenLoaded('municipality')),
            'gallery'       => GalleryResource::collection($this->whenLoaded('galleries')),
            'sections'      => SectionResource::collection($this->whenLoaded('sections')),
            'keywords'      => KeywordResource::collection($this->whenLoaded('keywords')),
        ];



        return $data;
    }
}