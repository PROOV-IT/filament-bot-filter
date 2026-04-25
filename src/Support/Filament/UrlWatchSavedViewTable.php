<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

final class UrlWatchSavedViewTable
{
    public static function make(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('panel_label')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.panel'))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('panel', $direction)),
                IconColumn::make('is_default')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.is_default'))
                    ->boolean(),
                TextColumn::make('sort_summary')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.sort'))
                    ->toggleable(),
                TextColumn::make('filters_summary')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.filters'))
                    ->toggleable(),
                TextColumn::make('column_searches_summary')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.column_searches'))
                    ->toggleable(),
                TextColumn::make('applied_count')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.applied_count'))
                    ->sortable(),
                TextColumn::make('last_applied_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.last_applied_at'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.updated_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('panel')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.panel'))
                    ->options([
                        'admin' => __('filament-url-watcher::filament-url-watcher.table.panel.admin'),
                        'manager' => __('filament-url-watcher::filament-url-watcher.table.panel.manager'),
                        'b2b' => __('filament-url-watcher::filament-url-watcher.table.panel.b2b'),
                        'other' => __('filament-url-watcher::filament-url-watcher.table.panel.other'),
                    ])
                    ->placeholder(__('filament-url-watcher::filament-url-watcher.saved_views.placeholders.panel')),
                SelectFilter::make('is_default')
                    ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.is_default'))
                    ->options([
                        'yes' => __('filament-url-watcher::filament-url-watcher.saved_views.values.yes'),
                        'no' => __('filament-url-watcher::filament-url-watcher.saved_views.values.no'),
                    ])
                    ->placeholder(__('filament-url-watcher::filament-url-watcher.saved_views.placeholders.any'))
                    ->query(function ($query, array $data) {
                        if (! isset($data['value']) || $data['value'] === null) {
                            return;
                        }

                        if ($data['value'] === 'yes') {
                            $query->where('is_default', true);
                        } elseif ($data['value'] === 'no') {
                            $query->where('is_default', false);
                        }
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-url-watcher::filament-url-watcher.actions.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (UrlWatchSavedView $record) => UrlWatchSavedViewResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
