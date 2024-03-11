<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'articles' => ArticleResource::collection($this->whenLoaded('articles')),
        ];
    
        if(!$request->has('include')){
            return $data;
        }

        $includes = explode(',', $request->include);
        
        if (in_array('articlesCount', $includes)) {
            $data['articlesCount'] = $this->articles_count;
        }
    
        return $data;
    }
}
