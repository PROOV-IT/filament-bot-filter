<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchEventInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextEntry::make('occurred_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.occurred_at'))
                    ->dateTime(),
                TextEntry::make('urlWatch.normalized_path')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.watch')),
                TextEntry::make('method')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.method')),
                TextEntry::make('status_code')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status_code')),
                TextEntry::make('host')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.host')),
                TextEntry::make('panel')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.panel')),
                TextEntry::make('path')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.path'))
                    ->columnSpanFull(),
                TextEntry::make('full_url')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.full_url'))
                    ->columnSpanFull(),
                TextEntry::make('route_name')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.route_name')),
                TextEntry::make('request_id')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.request_id')),
                TextEntry::make('ip')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.ip')),
                TextEntry::make('user_agent')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.user_agent'))
                    ->columnSpanFull(),
                TextEntry::make('referer')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.referer'))
                    ->columnSpanFull(),
                TextEntry::make('exception_class')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.exception_class'))
                    ->columnSpanFull(),
                TextEntry::make('exception_message')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.exception_message'))
                    ->columnSpanFull(),
                TextEntry::make('meta')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.meta'))
                    ->state(fn (UrlWatchEvent $record): string => json_encode($record->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}')
                    ->copyable()
                    ->columnSpanFull(),
            ]),
        ]);
    }
}
