<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;

final class ListBotProbeSavedViews extends ListRecords
{
    protected static string $resource = BotProbeSavedViewResource::class;
}
