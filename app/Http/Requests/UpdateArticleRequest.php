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
        //'image.id' => 'required|integer|exists:files,id',
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|string|in:DRAFT,PUBLISHED,UNPUBLISHED,draft,published,unpublished',
            'summary' => 'required|string',
            'author.id' => 'required|integer|exists:authors,id',
            'category.id'  => 'required|integer|exists:categories,id',
            'municipality.id' =>  'required|integer|exists:municipalities,id'
          
        ];
    }
}

