<?php

namespace App\Providers;

use App\Article;
use App\Comment;
use App\Events\BalanceChargeAlarmEvent;
use App\Observers\ArticleObserver;
use App\Observers\CommentObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\BalanceChargeAlarmEvent' => [
            'App\Listeners\BalanceChargeAlarmListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        User::observe(UserObserver::class);
        Article::observe(ArticleObserver::class);
        Comment::observe(CommentObserver::class);
        //
    }
}
