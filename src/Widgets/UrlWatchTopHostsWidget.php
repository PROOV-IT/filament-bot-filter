<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchTopHostsWidget extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('filament-url-watcher::filament-url-watcher.widgets.top_hosts.heading');
    }

    protected function getData(): array
    {
        $rows = UrlWatchEvent::query()
            ->selectRaw('COALESCE(NULLIF(host, \'\'), \'-\') as label, count(*) as total')
            ->groupByRaw('COALESCE(NULLIF(host, \'\'), \'-\')')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('filament-url-watcher::filament-url-watcher.widgets.top_hosts.hits'),
                    'data' => $rows->pluck('total')->all(),
                ],
            ],
            'labels' => $rows->pluck('label')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
