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
            'id'            => $this->id,
            'name'          => $this->user->name,
            'biography'     => $this->biography,
            'image'         => new FileResource($this->user->image),
            'articles'      => ArticleResource::collection($this->whenLoaded('articles')),
        ];
    }
}
