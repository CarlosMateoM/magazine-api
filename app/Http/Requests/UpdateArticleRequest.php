<?php

namespace App\Http\Requests;

use App\Enums\ArticleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

            'title'             => 'required|string|max:255|unique:articles,title,' . $this->route('article')->id,
            'status'            => Rule::enum(ArticleStatus::class),
            'content'           => 'string',
            'summary'           => 'string',
            
            'user.id'           => 'required|integer|exists:users,id',
            'file.id'           => 'required|integer|exists:files,id',
            'category.id'       => 'required|integer|exists:categories,id',
            'municipality.id'   => 'required|integer|exists:municipalities,id'
        ];
    }
}

