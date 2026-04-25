<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

final class ViewUrlWatchSavedView extends ViewRecord
{
    protected static string $resource = UrlWatchSavedViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
