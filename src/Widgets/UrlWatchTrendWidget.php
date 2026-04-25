<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchWidgetUrls;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchTrendWidget extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('filament-url-watcher::filament-url-watcher.widgets.trend.heading');
    }

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(fn (int $offset) => now()->subDays($offset)->toDateString());

        $data = $days->map(function (string $date): int {
            return UrlWatchEvent::query()->whereDate('occurred_at', $date)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => __('filament-url-watcher::filament-url-watcher.widgets.trend.probes'),
                    'data' => $data->values()->all(),
                ],
            ],
            'labels' => $days->values()->all(),
        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        $urls = collect(range(6, 0))
            ->map(fn (int $offset): string => UrlWatchWidgetUrls::eventsOnDate(now()->subDays($offset)->toDateString()))
            ->values()
            ->all();

        return RawJs::make(sprintf(<<<'JS'
{
    onClick: (event, elements, chart) => {
        if (! elements.length) {
            return;
        }

        const index = elements[0].index;
        const urls = %s;

        if (urls[index]) {
            window.location.href = urls[index];
        }
    }
}
JS, json_encode($urls)));
    }

    protected function getType(): string
    {
        return 'line';
    }
}
