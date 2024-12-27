<?php

namespace App\Http\Requests;

use App\Enums\ArticleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
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
            'title'             => 'required|string|max:255|unique:articles,title',
            'status'            => ['required', Rule::enum(ArticleStatus::class)],
            'summary'           => 'required|string',
            'published_at'      => 'required',
            'file_id'           => 'required|exists:files,id',
            'author_id'         => 'required|exists:authors,id',
            'category_id'       => 'required|exists:categories,id',
            'municipality_id'   => 'required|exists:municipalities,id',
            'keywords'          => 'nullable|array|exists:keywords,id',
        ];
    }
}

