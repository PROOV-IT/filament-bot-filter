<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;

final class ListUrlWatchEvents extends ListRecords
{
    protected static string $resource = UrlWatchEventResource::class;
}
