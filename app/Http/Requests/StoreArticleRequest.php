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
        return [
            'title' => 'required',
            'content' => 'required',
            'summary' => 'required',
            'image.id' => 'required|exists:files,id',
            'author.id' => 'required|exists:authors,id',
            'category.id' => 'required|exists:categories,id',
            'municipality.id' => 'required|exists:municipalities,id',
        ];
    }
}

