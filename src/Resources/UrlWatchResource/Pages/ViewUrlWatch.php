<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;

final class ViewUrlWatch extends ViewRecord
{
    protected static string $resource = UrlWatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
