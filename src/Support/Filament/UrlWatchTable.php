<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Enums\UrlWatchStatus;
use Proovit\UrlWatcher\Models\UrlWatch;
use Proovit\UrlWatcher\UrlWatcher;

final class UrlWatchTable
{
    public static function make(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('last_seen_at', 'desc')
            ->columns([
                TextColumn::make('normalized_path')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.path'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('host')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.host'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('panel')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.panel'))
                    ->badge()
                    ->toggleable(),
                TextColumn::make('classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchClassification ? $state->label() : (UrlWatchClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextColumn::make('status')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchStatus ? $state->label() : (UrlWatchStatus::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextColumn::make('suggested_classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.suggested_classification'))
                    ->formatStateUsing(static fn ($state) => $state instanceof UrlWatchClassification ? $state->label() : (UrlWatchClassification::tryFrom((string) $state)?->label() ?? '—')),
                TextColumn::make('count')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.count'))
                    ->sortable(),
                TextColumn::make('events_count')
                    ->counts('events')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.events_count'))
                    ->sortable(),
                TextColumn::make('latest_event_status')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.latest_status_code'))
                    ->state(fn (UrlWatch $record): string => (string) ($record->events()->latest('occurred_at')->value('status_code') ?? '—'))
                    ->toggleable(),
                IconColumn::make('notified_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.notified'))
                    ->boolean()
                    ->state(fn (UrlWatch $record): bool => filled($record->notified_at))
                    ->toggleable(),
                TextColumn::make('last_seen_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.last_seen_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('classification')
                    ->options(collect(UrlWatchClassification::cases())->mapWithKeys(fn (UrlWatchClassification $case) => [$case->value => $case->label()])->all()),
                SelectFilter::make('status')
                    ->options(collect(UrlWatchStatus::cases())->mapWithKeys(fn (UrlWatchStatus $case) => [$case->value => $case->label()])->all()),
                SelectFilter::make('panel')
                    ->options([
                        'admin' => __('filament-url-watcher::filament-url-watcher.table.panel.admin'),
                        'manager' => __('filament-url-watcher::filament-url-watcher.table.panel.manager'),
                        'b2b' => __('filament-url-watcher::filament-url-watcher.table.panel.b2b'),
                        'other' => __('filament-url-watcher::filament-url-watcher.table.panel.other'),
                    ]),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (UrlWatch $record) => UrlWatchResource::getUrl('view', ['record' => $record])),
                Action::make('history')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.history'))
                    ->icon('heroicon-o-clock')
                    ->url(fn (UrlWatch $record) => UrlWatchEventResource::getUrl('index', [
                        'watch' => $record->getKey(),
                    ])),
                Action::make('mark_bot')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_bot'))
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->action(fn (UrlWatch $record) => app(UrlWatcher::class)->classify($record, UrlWatchClassification::Bot)),
                Action::make('mark_normal')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_normal'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (UrlWatch $record) => app(UrlWatcher::class)->classify($record, UrlWatchClassification::Normal)),
                Action::make('mark_ignored')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_ignored'))
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->action(fn (UrlWatch $record) => app(UrlWatcher::class)->classify($record, UrlWatchClassification::Ignored)),
                Action::make('reset_review')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.reset_review'))
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (UrlWatch $record): void {
                        $record->markAsPending();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_bot')
                        ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_bot'))
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->action(function (Collection $records): void {
                            $updated = 0;

                            foreach ($records as $record) {
                                if (! $record instanceof UrlWatch) {
                                    continue;
                                }

                                app(UrlWatcher::class)->classify($record, UrlWatchClassification::Bot);
                                $updated++;
                            }

                            Notification::make()
                                ->title(__('filament-url-watcher::filament-url-watcher.bulk_actions.updated'))
                                ->body(__('filament-url-watcher::filament-url-watcher.bulk_actions.count', ['count' => $updated]))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('mark_normal')
                        ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_normal'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $updated = 0;

                            foreach ($records as $record) {
                                if (! $record instanceof UrlWatch) {
                                    continue;
                                }

                                app(UrlWatcher::class)->classify($record, UrlWatchClassification::Normal);
                                $updated++;
                            }

                            Notification::make()
                                ->title(__('filament-url-watcher::filament-url-watcher.bulk_actions.updated'))
                                ->body(__('filament-url-watcher::filament-url-watcher.bulk_actions.count', ['count' => $updated]))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('mark_ignored')
                        ->label(__('filament-url-watcher::filament-url-watcher.actions.mark_ignored'))
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->action(function (Collection $records): void {
                            $updated = 0;

                            foreach ($records as $record) {
                                if (! $record instanceof UrlWatch) {
                                    continue;
                                }

                                app(UrlWatcher::class)->classify($record, UrlWatchClassification::Ignored);
                                $updated++;
                            }

                            Notification::make()
                                ->title(__('filament-url-watcher::filament-url-watcher.bulk_actions.updated'))
                                ->body(__('filament-url-watcher::filament-url-watcher.bulk_actions.count', ['count' => $updated]))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('reset_review')
                        ->label(__('filament-url-watcher::filament-url-watcher.actions.reset_review'))
                        ->icon('heroicon-o-arrow-path')
                        ->action(function (Collection $records): void {
                            $updated = 0;

                            foreach ($records as $record) {
                                if (! $record instanceof UrlWatch) {
                                    continue;
                                }

                                $record->markAsPending();
                                $updated++;
                            }

                            Notification::make()
                                ->title(__('filament-url-watcher::filament-url-watcher.bulk_actions.updated'))
                                ->body(__('filament-url-watcher::filament-url-watcher.bulk_actions.count', ['count' => $updated]))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(static function (Builder $query): Builder {
                return $query->orderByDesc('last_seen_at')->orderByDesc('count');
            });
    }
}
