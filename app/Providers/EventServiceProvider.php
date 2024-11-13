<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserActionEvent;
use App\Listeners\LogUserActionListener;
use App\Events\SystemEventOccurred;
use App\Listeners\LogSystemEventListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserActionEvent::class => [
            LogUserActionListener::class,
        ],
        SystemEventOccurred::class => [
            LogSystemEventListener::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
