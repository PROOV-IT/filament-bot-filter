<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

final class EditUrlWatchSavedView extends EditRecord
{
    protected static string $resource = UrlWatchSavedViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
