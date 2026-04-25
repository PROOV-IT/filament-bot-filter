<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Proovit\BotFilter\Contracts\BotFilterSettingsRepositoryInterface;
use Proovit\FilamentBotFilter\Pages\BotFilterSettingsPage;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;
use Proovit\FilamentBotFilter\Resources\BotProbeResource;
use Proovit\FilamentBotFilter\Widgets\BotProbeStatsWidget;
use Proovit\FilamentBotFilter\Widgets\BotProbeTopPathsWidget;
use Proovit\FilamentBotFilter\Widgets\BotProbeTrendWidget;

final class FilamentBotFilterPlugin implements Plugin
{
    public static function make(): self
    {
        return new self;
    }

    public function getId(): string
    {
        return 'bot-filter';
    }

    public function register(Panel $panel): void
    {
        if (! (bool) config('filament-bot-filter.enabled', true)) {
            return;
        }

        $panel
            ->resources([
                BotProbeResource::class,
                BotProbeSavedViewResource::class,
            ])
            ->pages([
                BotFilterSettingsPage::class,
            ])
            ->widgets(
                $this->shouldShowWidgets()
                    ? [
                        BotProbeStatsWidget::class,
                        BotProbeTrendWidget::class,
                        BotProbeTopPathsWidget::class,
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
        if (! (bool) config('filament-bot-filter.show_widgets', true)) {
            return false;
        }

        try {
            return (bool) app(BotFilterSettingsRepositoryInterface::class)
                ->settings()
                ->show_widgets;
        } catch (\Throwable) {
            return true;
        }
    }
}
