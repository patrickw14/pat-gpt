<?php

namespace App\Providers;

use App\Events\UserMessageSent;
use App\Listeners\GenerateSystemResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserMessageSent::class => [
            GenerateSystemResponse::class,
        ],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
