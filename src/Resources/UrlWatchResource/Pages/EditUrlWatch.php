<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;

final class EditUrlWatch extends EditRecord
{
    protected static string $resource = UrlWatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
