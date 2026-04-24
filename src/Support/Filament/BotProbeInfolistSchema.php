<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Proovit\BotFilter\Enums\BotProbeClassification;
use Proovit\BotFilter\Enums\BotProbeStatus;
use Proovit\BotFilter\Models\BotProbe;

final class BotProbeInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextEntry::make('path')->label(__('filament-bot-filter::filament-bot-filter.fields.path')),
                TextEntry::make('normalized_path')->label(__('filament-bot-filter::filament-bot-filter.fields.normalized_path')),
                TextEntry::make('host')->label(__('filament-bot-filter::filament-bot-filter.fields.host')),
                TextEntry::make('panel')->label(__('filament-bot-filter::filament-bot-filter.fields.panel')),
                TextEntry::make('exception_class')->label(__('filament-bot-filter::filament-bot-filter.fields.exception_class')),
                TextEntry::make('route_name')->label(__('filament-bot-filter::filament-bot-filter.fields.route_name')),
                TextEntry::make('classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeClassification ? $state->label() : (BotProbeClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('suggested_classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.suggested_classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeClassification ? $state->label() : (BotProbeClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('status')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.status'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeStatus ? $state->label() : (BotProbeStatus::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('count')->label(__('filament-bot-filter::filament-bot-filter.fields.count')),
                TextEntry::make('first_seen_at')->label(__('filament-bot-filter::filament-bot-filter.fields.first_seen_at'))->dateTime(),
                TextEntry::make('last_seen_at')->label(__('filament-bot-filter::filament-bot-filter.fields.last_seen_at'))->dateTime(),
                TextEntry::make('notified_at')->label(__('filament-bot-filter::filament-bot-filter.fields.notified_at'))->dateTime(),
                TextEntry::make('meta')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.meta'))
                    ->columnSpanFull()
                    ->state(fn (BotProbe $record) => json_encode($record->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->copyable(),
            ]),
        ]);
    }
}
