<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages;

use Proovit\FilamentBotFilter\Resources\BotProbeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditBotProbe extends EditRecord
{
    protected static string $resource = BotProbeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
