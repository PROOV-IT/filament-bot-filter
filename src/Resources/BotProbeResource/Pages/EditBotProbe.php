<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBotFilter\Resources\BotProbeResource;

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
