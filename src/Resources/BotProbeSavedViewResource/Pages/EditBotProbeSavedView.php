<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;

final class EditBotProbeSavedView extends EditRecord
{
    protected static string $resource = BotProbeSavedViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
