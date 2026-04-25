<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter;

use Illuminate\Support\ServiceProvider;

final class FilamentBotFilterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-bot-filter.php', 'filament-bot-filter');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-bot-filter');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-bot-filter');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/filament-bot-filter.php' => config_path('filament-bot-filter.php'),
            ], 'filament-bot-filter-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'filament-bot-filter-migrations');
        }

        if ((bool) config('filament-bot-filter.enabled', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
}
