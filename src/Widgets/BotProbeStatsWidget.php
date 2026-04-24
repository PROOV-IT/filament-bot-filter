<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Proovit\BotFilter\Enums\BotProbeClassification;
use Proovit\BotFilter\Enums\BotProbeStatus;
use Proovit\BotFilter\Models\BotProbe;

final class BotProbeStatsWidget extends StatsOverviewWidget
{
    protected function getHeading(): ?string
    {
        return __('filament-bot-filter::filament-bot-filter.widgets.stats.heading');
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('filament-bot-filter::filament-bot-filter.widgets.stats.pending'), BotProbe::query()->where('status', BotProbeStatus::Pending->value)->count()),
            Stat::make(__('filament-bot-filter::filament-bot-filter.widgets.stats.bots'), BotProbe::query()->where('classification', BotProbeClassification::Bot->value)->count()),
            Stat::make(__('filament-bot-filter::filament-bot-filter.widgets.stats.reviewed'), BotProbe::query()->where('status', BotProbeStatus::Reviewed->value)->count()),
            Stat::make(__('filament-bot-filter::filament-bot-filter.widgets.stats.today'), BotProbe::query()->whereDate('created_at', now()->toDateString())->count()),
        ];
    }
}
