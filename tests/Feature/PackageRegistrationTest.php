<?php

declare(strict_types=1);

use Proovit\FilamentUrlWatcher\FilamentUrlWatcherPlugin;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

it('registers the filament URL watcher plugin', function (): void {
    expect(FilamentUrlWatcherPlugin::make()->getId())->toBe('url-watcher');
    expect(UrlWatchEventResource::shouldRegisterNavigation())->toBeTrue();
    expect(UrlWatchSavedViewResource::shouldRegisterNavigation())->toBeTrue();
});
