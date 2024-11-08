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
        /*
        remove to improve flexibility of the request and validate in business logic

        todo: add nullable to the fields that are not required in database
        'content' => '',
        'summary' => '',
        'image.id' => '',


        */

        return [
            'title' => 'required|string|max:255|unique:articles,title',
            'status' => [Rule::enum(ArticleStatus::class)],
            'summary' => 'string',
            'content' => 'nullable|string',
            //'publishedAt' => '',

            'user.id' => 'required|exists:users,id',
            'file.id' => 'required|exists:files,id',
            'category.id' => 'required|exists:categories,id',
            'municipality.id' => 'required|exists:municipalities,id',
        ];
    }
}

