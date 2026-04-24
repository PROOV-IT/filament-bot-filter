<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBotFilter\Resources\BotProbeResource;

final class ViewBotProbe extends ViewRecord
{
    protected static string $resource = BotProbeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
