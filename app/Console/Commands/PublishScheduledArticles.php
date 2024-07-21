<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class PublishScheduledArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish articles that are scheduled for a future date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articles = Article::where('status', 'draft')
            ->where('published_at', '<=', now())
            ->get();

        $articles->each(function ($article) {
            $article->update(['status' => 'published']);
            $this->info('Published article: ' . $article->title);
        });

        $this->info('Published ' . $articles->count() . ' scheduled articles');
    }
}
