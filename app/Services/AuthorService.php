<?php

namespace App\Services;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorService
{

    public function getAuthors(Request $request)
    {
        $authors = QueryBuilder::for(Author::class)
            ->filterByName()
            ->allowedIncludes([
                'file',
                'articles'
            ]);

        return $authors->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getAuthor(Author $author): Author
    {
        return $author->load('file');
    }

    public function createAuthor(StoreAuthorRequest $request): Author
    {
        $author = new Author();

        $author->first_name =   $request->input('firstName');
        $author->last_name  =   $request->input('lastName');
        $author->biography  =   $request->input('biography');
        $author->file_id    =   $request->input('image.id');

        $author->save();

        return $author;
    }

    public function updateAuthor(UpdateAuthorRequest $request, Author $author): Author
    {

        $author->first_name =   $request->input('firstName');
        $author->last_name  =   $request->input('lastName');
        $author->biography  =   $request->input('biography');
        $author->file_id    =   $request->input('image.id');

        $author->save();

        return $author;
    }

    public function deleteAuthor(Author $author): void
    {
        $author->delete();
    }
}
