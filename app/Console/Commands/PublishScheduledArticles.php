<?php

namespace App\Console\Commands;

use App\Services\Article\ArticleService;
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
    public function handle(
        ArticleService $articleService
    )
    {
        $articleService->publishScheduledArticles();
    }
}
