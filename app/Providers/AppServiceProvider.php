<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Services\AuthService;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, UserRepository::class);
        $this->app->singleton(AuthService::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
