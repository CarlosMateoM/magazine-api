<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|string|in:DRAFT,PUBLISHED,UNPUBLISHED,draft,published,unpublished',
            'summary' => 'required|string',
            'publishedAt' => 'nullable|date',
            'image.id' => 'required|integer|exists:files,id',
            'category.id'  => 'required|integer|exists:categories,id',
            //'municipality.id' =>  'required|integer|exists:municipalities,id'
          
        ];
    }
}

/*
        $article->title = $request->title;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->published_at = $request->publishedAt;
        $article->file_id = $request->image['id'];
        $article->category_id = $request->category['id'];
        
        /*
        TODO: Fix this when update    
        $article->author_id = $request->author['id'];
        $article->municipality_id = $request->municipalityId;
*/
