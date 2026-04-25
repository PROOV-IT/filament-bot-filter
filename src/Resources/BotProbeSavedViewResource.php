<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBotFilter\Models\BotProbeSavedView;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages\EditBotProbeSavedView;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages\ListBotProbeSavedViews;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource\Pages\ViewBotProbeSavedView;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeSavedViewFormSchema;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeSavedViewInfolistSchema;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeSavedViewTable;

final class BotProbeSavedViewResource extends Resource
{
    protected static ?string $model = BotProbeSavedView::class;

    protected static ?string $slug = 'security/bot-probe-saved-views';

    public static function getModelLabel(): string
    {
        return __('filament-bot-filter::filament-bot-filter.saved_views.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-bot-filter::filament-bot-filter.saved_views.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return BotProbeSavedViewFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BotProbeSavedViewInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return BotProbeSavedViewTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config(
            'filament-bot-filter.navigation_group',
            __('filament-bot-filter::filament-bot-filter.saved_views.navigation_group')
        );
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return (string) config('filament-bot-filter.saved_views_navigation_icon', 'heroicon-o-book-open');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) config('filament-bot-filter.saved_views_navigation_sort', 98);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-bot-filter.show_saved_views_navigation', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBotProbeSavedViews::route('/'),
            'view' => ViewBotProbeSavedView::route('/{record}'),
            'edit' => EditBotProbeSavedView::route('/{record}/edit'),
        ];
    }
}
