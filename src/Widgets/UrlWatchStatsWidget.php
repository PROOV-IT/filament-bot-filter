<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchWidgetUrls;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Enums\UrlWatchStatus;
use Proovit\UrlWatcher\Models\UrlWatch;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchStatsWidget extends StatsOverviewWidget
{
    protected function getHeading(): ?string
    {
        return __('filament-url-watcher::filament-url-watcher.widgets.stats.heading');
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('filament-url-watcher::filament-url-watcher.widgets.stats.pending'), UrlWatch::query()->where('status', UrlWatchStatus::Pending->value)->count())
                ->url(UrlWatchWidgetUrls::watchesPreset('pending_review')),
            Stat::make(__('filament-url-watcher::filament-url-watcher.widgets.stats.bots'), UrlWatch::query()->where('classification', UrlWatchClassification::Bot->value)->count())
                ->url(UrlWatchWidgetUrls::watchesPreset('confirmed_bots')),
            Stat::make(__('filament-url-watcher::filament-url-watcher.widgets.stats.reviewed'), UrlWatch::query()->where('status', UrlWatchStatus::Reviewed->value)->count())
                ->url(UrlWatchWidgetUrls::watchesPreset('reviewed')),
            Stat::make(__('filament-url-watcher::filament-url-watcher.widgets.stats.events_today'), UrlWatchEvent::query()->whereDate('occurred_at', now()->toDateString())->count())
                ->url(UrlWatchWidgetUrls::eventsOnDate(now()->toDateString())),
        ];
    }
}
