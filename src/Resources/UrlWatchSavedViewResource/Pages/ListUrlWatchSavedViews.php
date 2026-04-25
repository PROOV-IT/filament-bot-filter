<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

final class ListUrlWatchSavedViews extends ListRecords
{
    protected static string $resource = UrlWatchSavedViewResource::class;
}
