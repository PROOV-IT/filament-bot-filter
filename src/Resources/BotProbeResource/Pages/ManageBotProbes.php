<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBotFilter\Resources\BotProbeResource;

final class ManageBotProbes extends ManageRecords
{
    protected static string $resource = BotProbeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->hidden(),
        ];
    }
}
