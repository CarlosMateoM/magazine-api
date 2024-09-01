<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => 'string|required|max:255|unique:articles,title',
            'author.id' => 'required|exists:authors,id',
            'category.id' => 'required|exists:categories,id',
            'municipality.id' => 'required|exists:municipalities,id',
        ];
    }
}

