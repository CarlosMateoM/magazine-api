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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' =>$this->content,
            'status' =>$this->status,
            'summary' =>$this->summary,
            'publishedAt' =>$this->published_at,
            'image' => new ImageResource($this->whenLoaded('image')),
            'category' => new CategoryResource($this->whenLoaded('category')),

        ];
    }
}

/*

  'title',
        'content',
        'status',
        'summary',
        'published_at',
        'author_id',
        'category_id',
        'image_id',
        'municipality_id',
*/

