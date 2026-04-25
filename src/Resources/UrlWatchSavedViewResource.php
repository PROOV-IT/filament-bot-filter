<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages\EditUrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages\ListUrlWatchSavedViews;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource\Pages\ViewUrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchSavedViewFormSchema;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchSavedViewInfolistSchema;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchSavedViewTable;

final class UrlWatchSavedViewResource extends Resource
{
    protected static ?string $model = UrlWatchSavedView::class;

    protected static ?string $slug = 'security/url-watch-saved-views';

    public static function getModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.saved_views.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-url-watcher::filament-url-watcher.saved_views.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return UrlWatchSavedViewFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UrlWatchSavedViewInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return UrlWatchSavedViewTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config(
            'filament-url-watcher.navigation_group',
            __('filament-url-watcher::filament-url-watcher.saved_views.navigation_group')
        );
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return (string) config('filament-url-watcher.saved_views_navigation_icon', 'heroicon-o-book-open');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) config('filament-url-watcher.saved_views_navigation_sort', 98);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-url-watcher.show_saved_views_navigation', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUrlWatchSavedViews::route('/'),
            'view' => ViewUrlWatchSavedView::route('/{record}'),
            'edit' => EditUrlWatchSavedView::route('/{record}/edit'),
        ];
    }
}
