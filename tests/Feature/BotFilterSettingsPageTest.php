<?php

declare(strict_types=1);

use Proovit\FilamentBotFilter\Pages\BotFilterSettingsPage;

it('exposes the bot filter settings page navigation by default', function (): void {
    expect(BotFilterSettingsPage::getNavigationLabel())->toBeString();
    expect(BotFilterSettingsPage::shouldRegisterNavigation())->toBeTrue();
});

it('respects the settings page navigation flag', function (): void {
    config()->set('filament-bot-filter.show_settings_navigation', false);

    expect(BotFilterSettingsPage::shouldRegisterNavigation())->toBeFalse();
});
