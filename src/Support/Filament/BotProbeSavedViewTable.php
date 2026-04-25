<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Proovit\FilamentBotFilter\Models\BotProbeSavedView;
use Proovit\FilamentBotFilter\Resources\BotProbeSavedViewResource;

final class BotProbeSavedViewTable
{
    public static function make(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('panel_label')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.panel'))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('panel', $direction)),
                IconColumn::make('is_default')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.is_default'))
                    ->boolean(),
                TextColumn::make('sort_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.sort'))
                    ->toggleable(),
                TextColumn::make('filters_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.filters'))
                    ->toggleable(),
                TextColumn::make('column_searches_summary')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.column_searches'))
                    ->toggleable(),
                TextColumn::make('applied_count')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.applied_count'))
                    ->sortable(),
                TextColumn::make('last_applied_at')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.last_applied_at'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.updated_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('panel')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.panel'))
                    ->options([
                        'admin' => __('filament-bot-filter::filament-bot-filter.table.panel.admin'),
                        'manager' => __('filament-bot-filter::filament-bot-filter.table.panel.manager'),
                        'b2b' => __('filament-bot-filter::filament-bot-filter.table.panel.b2b'),
                        'other' => __('filament-bot-filter::filament-bot-filter.table.panel.other'),
                    ])
                    ->placeholder(__('filament-bot-filter::filament-bot-filter.saved_views.placeholders.panel')),
                SelectFilter::make('is_default')
                    ->label(__('filament-bot-filter::filament-bot-filter.saved_views.fields.is_default'))
                    ->options([
                        'yes' => __('filament-bot-filter::filament-bot-filter.saved_views.values.yes'),
                        'no' => __('filament-bot-filter::filament-bot-filter.saved_views.values.no'),
                    ])
                    ->placeholder(__('filament-bot-filter::filament-bot-filter.saved_views.placeholders.any'))
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
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (BotProbeSavedView $record) => BotProbeSavedViewResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
