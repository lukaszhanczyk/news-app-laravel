<?php

namespace App\Providers;

use App\Console\Commands\UpdateNewsCommand;
use App\Http\Services\Clients\HttpApiClient;
use App\Http\Services\Clients\NewsApiClient;
use App\Http\Services\Updaters\NewsApiUpdater;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UpdateNewsCommand::class, function ($app) {
            return new UpdateNewsCommand($app->make(NewsApiUpdater::class));
        });
        $this->app->bind(NewsApiUpdater::class, function ($app) {
            return new NewsApiUpdater($app->make(NewsApiClient::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
