<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Proovit\BotFilter\BotFilter;
use Proovit\BotFilter\Enums\BotProbeClassification;
use Proovit\BotFilter\Enums\BotProbeStatus;
use Proovit\BotFilter\Models\BotProbe;
use Proovit\FilamentBotFilter\Resources\BotProbeResource;

final class BotProbeTable
{
    public static function make(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('last_seen_at', 'desc')
            ->columns([
                TextColumn::make('normalized_path')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.path'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('host')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.host'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.classification'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeClassification ? $state->label() : (BotProbeClassification::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextColumn::make('status')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.status'))
                    ->badge()
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeStatus ? $state->label() : (BotProbeStatus::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))),
                TextColumn::make('suggested_classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.suggested_classification'))
                    ->formatStateUsing(static fn ($state) => $state instanceof BotProbeClassification ? $state->label() : (BotProbeClassification::tryFrom((string) $state)?->label() ?? '—')),
                TextColumn::make('count')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.count'))
                    ->sortable(),
                TextColumn::make('last_seen_at')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.last_seen_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('classification')
                    ->options(collect(BotProbeClassification::cases())->mapWithKeys(fn (BotProbeClassification $case) => [$case->value => $case->label()])->all()),
                SelectFilter::make('status')
                    ->options(collect(BotProbeStatus::cases())->mapWithKeys(fn (BotProbeStatus $case) => [$case->value => $case->label()])->all()),
                SelectFilter::make('panel')
                    ->options([
                        'admin' => __('filament-bot-filter::filament-bot-filter.table.panel.admin'),
                        'manager' => __('filament-bot-filter::filament-bot-filter.table.panel.manager'),
                        'b2b' => __('filament-bot-filter::filament-bot-filter.table.panel.b2b'),
                        'other' => __('filament-bot-filter::filament-bot-filter.table.panel.other'),
                    ]),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (BotProbe $record) => BotProbeResource::getUrl('view', ['record' => $record])),
                Action::make('mark_bot')
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.mark_bot'))
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->action(fn (BotProbe $record) => app(BotFilter::class)->classify($record, BotProbeClassification::Bot)),
                Action::make('mark_normal')
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.mark_normal'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (BotProbe $record) => app(BotFilter::class)->classify($record, BotProbeClassification::Normal)),
                Action::make('mark_ignored')
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.mark_ignored'))
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->action(fn (BotProbe $record) => app(BotFilter::class)->classify($record, BotProbeClassification::Ignored)),
                Action::make('reset_review')
                    ->label(__('filament-bot-filter::filament-bot-filter.actions.reset_review'))
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (BotProbe $record): void {
                        $record->markAsPending();
                    }),
            ])
            ->modifyQueryUsing(static function (Builder $query): Builder {
                return $query->orderByDesc('last_seen_at')->orderByDesc('count');
            });
    }
}
