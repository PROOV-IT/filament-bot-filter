<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;

final class ViewBotProbeSavedView extends ViewRecord
{
    protected static string $resource = BotProbeSavedViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
