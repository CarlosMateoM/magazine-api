<?php

namespace App\Services;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorService
{

    public function getAuthors()
    {
        $authors = QueryBuilder::for(Author::class)
            ->filterByName()
            ->allowedIncludes([
                'file',
                'articles'
            ]);

        return $authors;
    }

    public function createAuthor(StoreAuthorRequest $request): Author
    {
        $author = new Author();

        $author->first_name = $request->firstName;
        $author->last_name = $request->lastName;
        $author->biography = $request->biography;
        $author->file_id = $request->file['id'];

        $author->save();

        return $author;
    }

    public function updateAuthor(UpdateAuthorRequest $request, Author $author): Author
    {

        $author->first_name = $request->firstName;
        $author->last_name = $request->lastName;
        $author->biography = $request->biography;
        $author->file_id


        return $author;
    }
}
