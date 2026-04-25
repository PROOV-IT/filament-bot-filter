<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchTopPathsWidget extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('filament-url-watcher::filament-url-watcher.widgets.top_paths.heading');
    }

    protected function getData(): array
    {
        $rows = UrlWatchEvent::query()
            ->selectRaw('normalized_path, count(*) as total')
            ->groupBy('normalized_path')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('filament-url-watcher::filament-url-watcher.widgets.top_paths.hits'),
                    'data' => $rows->pluck('total')->all(),
                ],
            ],
            'labels' => $rows->pluck('normalized_path')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
