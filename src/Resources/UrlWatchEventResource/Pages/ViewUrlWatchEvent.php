<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class ViewUrlWatchEvent extends ViewRecord
{
    protected static string $resource = UrlWatchEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('watch')
                ->label(__('filament-url-watcher::filament-url-watcher.actions.open_watch'))
                ->icon('heroicon-o-window')
                ->url(function (UrlWatchEvent $record): string {
                    return UrlWatchResource::getUrl('view', ['record' => $record->url_watch_id]);
                }),
        ];
    }
}
