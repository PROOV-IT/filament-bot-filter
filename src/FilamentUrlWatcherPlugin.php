<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Proovit\FilamentUrlWatcher\Pages\UrlWatcherSettingsPage;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;
use Proovit\FilamentUrlWatcher\Widgets\UrlWatchStatsWidget;
use Proovit\FilamentUrlWatcher\Widgets\UrlWatchTopPathsWidget;
use Proovit\FilamentUrlWatcher\Widgets\UrlWatchTrendWidget;
use Proovit\UrlWatcher\Contracts\UrlWatcherSettingsRepositoryInterface;

final class FilamentUrlWatcherPlugin implements Plugin
{
    public static function make(): self
    {
        return new self;
    }

    public function getId(): string
    {
        return 'url-watcher';
    }

    public function register(Panel $panel): void
    {
        if (! (bool) config('filament-url-watcher.enabled', true)) {
            return;
        }

        $panel
            ->resources([
                UrlWatchResource::class,
                UrlWatchEventResource::class,
                UrlWatchSavedViewResource::class,
            ])
            ->pages([
                UrlWatcherSettingsPage::class,
            ])
            ->widgets(
                $this->shouldShowWidgets()
                    ? [
                        UrlWatchStatsWidget::class,
                        UrlWatchTrendWidget::class,
                        UrlWatchTopPathsWidget::class,
                    ]
                    : []
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    private function shouldShowWidgets(): bool
    {
        if (! (bool) config('filament-url-watcher.show_widgets', true)) {
            return false;
        }

        try {
            return (bool) app(UrlWatcherSettingsRepositoryInterface::class)
                ->settings()
                ->show_widgets;
        } catch (\Throwable) {
            return true;
        }
    }
}
