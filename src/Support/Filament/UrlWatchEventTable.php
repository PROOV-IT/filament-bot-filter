<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Models\UrlWatchEvent;

final class UrlWatchEventTable
{
    public static function make(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('occurred_at', 'desc')
            ->columns([
                TextColumn::make('occurred_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.occurred_at'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('urlWatch.normalized_path')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.watch'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('method')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.method'))
                    ->badge(),
                TextColumn::make('host')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.host'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status_code')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status_code'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('panel')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.panel'))
                    ->badge()
                    ->toggleable(),
                TextColumn::make('exception_class')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.exception_class'))
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('request_id')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.request_id'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                        'PUT' => 'PUT',
                        'PATCH' => 'PATCH',
                        'DELETE' => 'DELETE',
                        'HEAD' => 'HEAD',
                        'OPTIONS' => 'OPTIONS',
                    ]),
                SelectFilter::make('panel')
                    ->options([
                        'admin' => __('filament-url-watcher::filament-url-watcher.table.panel.admin'),
                        'manager' => __('filament-url-watcher::filament-url-watcher.table.panel.manager'),
                        'b2b' => __('filament-url-watcher::filament-url-watcher.table.panel.b2b'),
                        'other' => __('filament-url-watcher::filament-url-watcher.table.panel.other'),
                    ]),
                SelectFilter::make('status_code')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status_code'))
                    ->options([
                        '404' => '404',
                        '405' => '405',
                        '419' => '419',
                        '429' => '429',
                        '500' => '500',
                    ]),
                SelectFilter::make('classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.classification'))
                    ->options(collect(UrlWatchClassification::cases())->mapWithKeys(
                        fn (UrlWatchClassification $case): array => [$case->value => $case->label()]
                    )->all())
                    ->query(function (Builder $query, array $data): void {
                        if (! filled($data['value'] ?? null)) {
                            return;
                        }

                        $query->whereHas('urlWatch', function (Builder $watchQuery) use ($data): void {
                            $watchQuery->where('classification', $data['value']);
                        });
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (UrlWatchEvent $record): string => UrlWatchEventResource::getUrl('view', ['record' => $record])),
                Action::make('watch')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.open_watch'))
                    ->icon('heroicon-o-window')
                    ->url(fn (UrlWatchEvent $record): string => UrlWatchResource::getUrl('view', ['record' => $record->url_watch_id])),
            ])
            ->modifyQueryUsing(static function (Builder $query): Builder {
                $watchId = request()->query('watch');

                return $query
                    ->with('urlWatch')
                    ->when(filled($watchId), static fn (Builder $watchQuery) => $watchQuery->where('url_watch_id', $watchId))
                    ->orderByDesc('occurred_at');
            });
    }
}
