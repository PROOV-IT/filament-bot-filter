<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Proovit\FilamentBotFilter\Models\BotProbeSavedView;

final class BotProbeSavedViewInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextEntry::make('name')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.name')),
                TextEntry::make('panel_label')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.panel')),
                TextEntry::make('is_default')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.is_default'))
                    ->badge()
                    ->formatStateUsing(static fn ($state): string => $state ? __('filament-bot-filter::filament-bot-filter.saved_views.values.yes') : __('filament-bot-filter::filament-bot-filter.saved_views.values.no')),
                TextEntry::make('description')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.description'))
                    ->columnSpanFull(),
                TextEntry::make('search')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.search'))
                    ->state(static fn (BotProbeSavedView $record): string => filled($record->search) ? (string) $record->search : '—'),
                TextEntry::make('sort_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.sort'))
                    ->state(static fn (BotProbeSavedView $record): string => $record->sort_summary),
                TextEntry::make('filters_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.filters'))
                    ->state(static fn (BotProbeSavedView $record): string => $record->filters_summary),
                TextEntry::make('column_searches_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.column_searches'))
                    ->state(static fn (BotProbeSavedView $record): string => $record->column_searches_summary),
                TextEntry::make('applied_count')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.applied_count')),
                TextEntry::make('last_applied_at')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.last_applied_at'))
                    ->dateTime(),
            ]),
        ]);
    }
}
