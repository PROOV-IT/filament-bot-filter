<?php

declare(strict_types=1);

use Proovit\FilamentUrlWatcher\Pages\UrlWatcherSettingsPage;

it('exposes the URL watcher settings page navigation by default', function (): void {
    expect(UrlWatcherSettingsPage::getNavigationLabel())->toBeString();
    expect(UrlWatcherSettingsPage::shouldRegisterNavigation())->toBeTrue();
});

it('respects the settings page navigation flag', function (): void {
    config()->set('filament-url-watcher.show_settings_navigation', false);

    expect(UrlWatcherSettingsPage::shouldRegisterNavigation())->toBeFalse();
});
