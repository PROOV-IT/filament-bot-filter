<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchWidgetUrls;
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

    protected function getOptions(): array|RawJs|null
    {
        $urls = UrlWatchEvent::query()
            ->selectRaw('normalized_path')
            ->selectRaw('count(*) as total')
            ->groupBy('normalized_path')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($row): string => UrlWatchWidgetUrls::eventsSearch((string) $row->normalized_path))
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
        return 'bar';
    }
}
