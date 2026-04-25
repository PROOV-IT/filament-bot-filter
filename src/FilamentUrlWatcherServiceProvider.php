<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher;

use Illuminate\Support\ServiceProvider;

final class FilamentUrlWatcherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-url-watcher.php', 'filament-url-watcher');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-url-watcher');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-url-watcher');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/filament-url-watcher.php' => config_path('filament-url-watcher.php'),
            ], 'filament-url-watcher-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'filament-url-watcher-migrations');
        }

        if ((bool) config('filament-url-watcher.enabled', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
}
