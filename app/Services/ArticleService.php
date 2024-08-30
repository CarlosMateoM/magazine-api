<?php

namespace App\Services;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\File;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{

    public function getArticles(Request $request)
    {

        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters([
                'user.id',
                'title',
                'published_at',
                'category.name',
                AllowedFilter::exact('sections.name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedIncludes([
                'file',
                'author.file',
                'category',
                'municipality',
                'advertisements.file'
            ])
            ->allowedSorts([
                'title',
                'published_at',
                'created_at'
            ])
            ->paginate(10)
            ->appends($request->query());

        if ($request->user()->hasRole('reader')) {
            $articles->where('status', 'published');
        }

        return $articles;
    }

    public function getArticle($id) {}

    /**
     * if the article is not an opinion article, the request must contain an image
     * to be used as the article's main image and the image must exist in the database
     */
    public function createArticle(StoreArticleRequest $request)
    {
        $article = new Article();

        if ($request->category['id'] !== Category::where('name', 'opinion')->first()->id) {

            $request->validate([
                'image.id' => 'required|exists:files,id'
            ]);

            //File::findOrFail($request->image['id']); possible implementation

            $article->file_id = $request->image['id'];
        }


        $article->title = $request->title;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->user_id = $request->user()->id;
        $article->slug = Str::slug($request->title);
        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];
        $article->published_at = $request->publishedAt;

        $article->save();
    }

    public function updateArticle($id, $data)
    {
        // 
    }

    public function deleteArticle($id)
    {
        // 
    }
}
