<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'biography' => $this->biography,
            'articlesCount' => $this->articles_count,
            'articles' => ArticleResource::collection($this->whenLoaded('articles')),
            'image' => new FileResource($this->whenLoaded('file')),
        ];
    }
}
