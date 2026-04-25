<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource\Pages\ListUrlWatchEvents;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource\Pages\ViewUrlWatchEvent;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchEventInfolistSchema;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchEventTable;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchEventResource extends Resource
{
    protected static ?string $model = UrlWatchEvent::class;

    protected static ?string $slug = 'security/url-watch-events';

    public static function getModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.resources.url_watch_event.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.resources.url_watch_event.plural');
    }

    public static function infolist(Schema $schema): Schema
    {
        return UrlWatchEventInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return UrlWatchEventTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config(
            'filament-url-watcher.navigation_group',
            __('filament-url-watcher::filament-url-watcher.resources.url_watch_event.navigation_group')
        );
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return (string) config('filament-url-watcher.history_navigation_icon', 'heroicon-o-clock');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) config('filament-url-watcher.history_navigation_sort', 98);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-url-watcher.show_history_navigation', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUrlWatchEvents::route('/'),
            'view' => ViewUrlWatchEvent::route('/{record}'),
        ];
    }
}
