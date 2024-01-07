<?php

namespace App\Providers;

use App\Console\Commands\UpdateNewsCommand;
use App\Http\Services\Clients\GuardianApiClient;
use App\Http\Services\Clients\NewsApiClient;
use App\Http\Services\Clients\NYTApiClient;
use App\Http\Services\Updaters\GuardianApiUpdater;
use App\Http\Services\Updaters\NewsApiUpdater;
use App\Http\Services\Updaters\NYTApiUpdater;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UpdateNewsCommand::class, function ($app) {
            return new UpdateNewsCommand(
                $app->make(NewsApiUpdater::class),
                $app->make(GuardianApiUpdater::class),
                $app->make(NYTApiUpdater::class)
            );
        });
        $this->app->bind(NYTApiUpdater::class, function ($app) {
            return new NYTApiUpdater($app->make(NYTApiClient::class));
        });
        $this->app->bind(GuardianApiUpdater::class, function ($app) {
            return new GuardianApiUpdater($app->make(GuardianApiClient::class));
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
