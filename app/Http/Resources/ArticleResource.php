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
            'content' => '',
            'status' =>$this->status,
            'summary' => $this->summary,
            'publishedAt' =>$this->published_at,
            'image' => new FileResource($this->whenLoaded('file')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'municipality' => new MunicipalityResource($this->whenLoaded('municipality')),

        ];

        if ($request->has('includeContent')) {
            $data['content'] = $this->content;
        }


        return $data;
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

