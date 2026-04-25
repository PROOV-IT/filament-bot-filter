<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
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

    protected function getType(): string
    {
        return 'line';
    }
}
