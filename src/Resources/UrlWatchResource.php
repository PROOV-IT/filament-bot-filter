<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages\EditUrlWatch;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages\ListUrlWatches;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages\ViewUrlWatch;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchFormSchema;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchInfolistSchema;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchTable;
use Proovit\UrlWatcher\Models\UrlWatch;

final class UrlWatchResource extends Resource
{
    protected static ?string $model = UrlWatch::class;

    protected static ?string $slug = 'security/url-watches';

    public static function getModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.resources.url_watch.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.resources.url_watch.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return UrlWatchFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UrlWatchInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return UrlWatchTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config(
            'filament-url-watcher.navigation_group',
            __('filament-url-watcher::filament-url-watcher.resources.url_watch.navigation_group')
        );
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return (string) config('filament-url-watcher.navigation_icon', 'heroicon-o-shield-exclamation');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) config('filament-url-watcher.navigation_sort', 99);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-url-watcher.show_navigation', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUrlWatches::route('/'),
            'view' => ViewUrlWatch::route('/{record}'),
            'edit' => EditUrlWatch::route('/{record}/edit'),
        ];
    }
}
