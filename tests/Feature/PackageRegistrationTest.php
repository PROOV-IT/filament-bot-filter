<?php

declare(strict_types=1);

use Proovit\FilamentBotFilter\FilamentBotFilterPlugin;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;

it('registers the filament bot filter plugin', function (): void {
    expect(FilamentBotFilterPlugin::make()->getId())->toBe('bot-filter');
    expect(BotProbeSavedViewResource::shouldRegisterNavigation())->toBeTrue();
});
