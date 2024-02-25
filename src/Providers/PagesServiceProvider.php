<?php

namespace Jaymeh\FilamentPages\Providers;

use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Pages';

    protected string $moduleNameLower = 'pages';

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', $this->moduleNameLower);

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/pages'),
        ], 'pages-views');

        $this->publishes(
            [
                __DIR__ . '/../../config/config.php' => config_path('pages.php'),
            ],
            'pages-config'
        );
    }

    public function register(): void
    {
        // $this->app->register(NovaServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'pages');
    }
}
