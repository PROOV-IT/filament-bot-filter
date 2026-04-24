<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Proovit\BotFilter\Enums\BotProbeClassification;
use Proovit\BotFilter\Enums\BotProbeStatus;

final class BotProbeFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextInput::make('path')->label(__('filament-bot-filter::filament-bot-filter.fields.path'))->disabled(),
                TextInput::make('normalized_path')->label(__('filament-bot-filter::filament-bot-filter.fields.normalized_path'))->disabled(),
                TextInput::make('host')->label(__('filament-bot-filter::filament-bot-filter.fields.host'))->disabled(),
                TextInput::make('panel')->label(__('filament-bot-filter::filament-bot-filter.fields.panel'))->disabled(),
                TextInput::make('exception_class')->label(__('filament-bot-filter::filament-bot-filter.fields.exception_class'))->disabled(),
                TextInput::make('route_name')->label(__('filament-bot-filter::filament-bot-filter.fields.route_name'))->disabled(),
                Select::make('classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.classification'))
                    ->options(collect(BotProbeClassification::cases())->mapWithKeys(fn (BotProbeClassification $case) => [$case->value => $case->label()])->all())
                    ->required(),
                Select::make('suggested_classification')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.suggested_classification'))
                    ->options(collect(BotProbeClassification::cases())->mapWithKeys(fn (BotProbeClassification $case) => [$case->value => $case->label()])->all())
                    ->disabled(),
                Select::make('status')
                    ->label(__('filament-bot-filter::filament-bot-filter.fields.status'))
                    ->options(collect(BotProbeStatus::cases())->mapWithKeys(fn (BotProbeStatus $case) => [$case->value => $case->label()])->all())
                    ->required(),
                TextInput::make('count')->label(__('filament-bot-filter::filament-bot-filter.fields.count'))->numeric()->disabled(),
                DateTimePicker::make('first_seen_at')->label(__('filament-bot-filter::filament-bot-filter.fields.first_seen_at'))->disabled(),
                DateTimePicker::make('last_seen_at')->label(__('filament-bot-filter::filament-bot-filter.fields.last_seen_at'))->disabled(),
                DateTimePicker::make('notified_at')->label(__('filament-bot-filter::filament-bot-filter.fields.notified_at')),
                KeyValue::make('meta')->label(__('filament-bot-filter::filament-bot-filter.fields.meta'))->disabled()->columnSpanFull(),
            ]),
        ]);
    }
}
