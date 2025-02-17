<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\NewsLetterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

class SendNewsLetterMailables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
     public array $subscribersIds
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $news = QueryBuilder::for(Article::class)
            ->allowedIncludes(['category', 'municipality'])
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        foreach ($this->subscribersIds as $subscriberId) {
            $suscriber = NewsLetterSubscription::findOrFail($subscriberId);
            Mail::to($suscriber->email)->send(new SendNewsLetterMailables($suscriber, ));
        }
    }
}
