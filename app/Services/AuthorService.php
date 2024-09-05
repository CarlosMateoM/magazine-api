<?php

namespace App\Services;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorService
{

    private const DEFAULT_PER_PAGE = 10;

    public function getAuthors(Request $request)
    {
        $authors = QueryBuilder::for(Author::class)
            ->filterByName()
            ->allowedIncludes([
                'file',
                'articles'
            ]);

        return $authors->paginate(self::DEFAULT_PER_PAGE)
            ->appends($request->query());
    }

    public function getAuthor(Author $author): Author
    {
        return $author->load('file');
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
        $author->file_id = $request->file['id'];

        $author->save();

        return $author;
    }

    public function deleteAuthor(Author $author): void
    {
        $author->delete();
    }
}
