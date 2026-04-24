<?php

declare(strict_types=1);

use Proovit\FilamentBotFilter\FilamentBotFilterPlugin;

it('registers the filament bot filter plugin', function (): void {
    expect(FilamentBotFilterPlugin::make()->getId())->toBe('bot-filter');
});
