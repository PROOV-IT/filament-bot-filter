<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Enums\UrlWatchStatus;
use Proovit\UrlWatcher\Models\UrlWatch;

final class UrlWatchInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextEntry::make('path')->label(__('filament-url-watcher::filament-url-watcher.fields.path')),
                TextEntry::make('normalized_path')->label(__('filament-url-watcher::filament-url-watcher.fields.normalized_path')),
                TextEntry::make('host')->label(__('filament-url-watcher::filament-url-watcher.fields.host')),
                TextEntry::make('panel')->label(__('filament-url-watcher::filament-url-watcher.fields.panel')),
                TextEntry::make('exception_class')->label(__('filament-url-watcher::filament-url-watcher.fields.exception_class')),
                TextEntry::make('route_name')->label(__('filament-url-watcher::filament-url-watcher.fields.route_name')),
                TextEntry::make('classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchClassification ? $state->label() : (UrlWatchClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('suggested_classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.suggested_classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchClassification ? $state->label() : (UrlWatchClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('status')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchStatus ? $state->label() : (UrlWatchStatus::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextEntry::make('count')->label(__('filament-url-watcher::filament-url-watcher.fields.count')),
                TextEntry::make('events_count')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.events_count'))
                    ->state(static fn (UrlWatch $record): int => $record->events()->count()),
                TextEntry::make('first_seen_at')->label(__('filament-url-watcher::filament-url-watcher.fields.first_seen_at'))->dateTime(),
                TextEntry::make('last_seen_at')->label(__('filament-url-watcher::filament-url-watcher.fields.last_seen_at'))->dateTime(),
                TextEntry::make('notified_at')->label(__('filament-url-watcher::filament-url-watcher.fields.notified_at'))->dateTime(),
                TextEntry::make('recent_events')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.recent_events'))
                    ->columnSpanFull()
                    ->state(static function (UrlWatch $record): string {
                        $lines = $record->events()
                            ->latest('occurred_at')
                            ->limit(5)
                            ->get()
                            ->map(static function ($event): string {
                                $timestamp = optional($event->occurred_at)->toDateTimeString() ?? '—';
                                $status = $event->status_code ?? '—';
                                $method = $event->method ?? '—';
                                $path = $event->path ?? '—';

                                return sprintf('[%s] %s %s (%s)', $timestamp, $method, $path, $status);
                            })
                            ->all();

                        return $lines === [] ? '—' : implode(PHP_EOL, $lines);
                    }),
                TextEntry::make('meta')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.meta'))
                    ->columnSpanFull()
                    ->state(fn (UrlWatch $record) => json_encode($record->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->copyable(),
            ]),
        ]);
    }
}
