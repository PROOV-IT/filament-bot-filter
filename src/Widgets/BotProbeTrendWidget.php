<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Widgets;

use Filament\Widgets\ChartWidget;
use Proovit\BotFilter\Models\BotProbe;

final class BotProbeTrendWidget extends ChartWidget
{
    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return __('filament-bot-filter::filament-bot-filter.widgets.trend.heading');
    }

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(fn (int $offset) => now()->subDays($offset)->toDateString());

        $data = $days->map(function (string $date): int {
            return BotProbe::query()->whereDate('created_at', $date)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => __('filament-bot-filter::filament-bot-filter.widgets.trend.probes'),
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
