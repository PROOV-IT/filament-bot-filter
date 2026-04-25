<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Enums\UrlWatchStatus;

final class UrlWatchFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextInput::make('path')->label(__('filament-url-watcher::filament-url-watcher.fields.path'))->disabled(),
                TextInput::make('normalized_path')->label(__('filament-url-watcher::filament-url-watcher.fields.normalized_path'))->disabled(),
                TextInput::make('host')->label(__('filament-url-watcher::filament-url-watcher.fields.host'))->disabled(),
                TextInput::make('panel')->label(__('filament-url-watcher::filament-url-watcher.fields.panel'))->disabled(),
                TextInput::make('exception_class')->label(__('filament-url-watcher::filament-url-watcher.fields.exception_class'))->disabled(),
                TextInput::make('route_name')->label(__('filament-url-watcher::filament-url-watcher.fields.route_name'))->disabled(),
                Select::make('classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.classification'))
                    ->options(collect(UrlWatchClassification::cases())->mapWithKeys(fn (UrlWatchClassification $case) => [$case->value => $case->label()])->all())
                    ->required(),
                Select::make('suggested_classification')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.suggested_classification'))
                    ->options(collect(UrlWatchClassification::cases())->mapWithKeys(fn (UrlWatchClassification $case) => [$case->value => $case->label()])->all())
                    ->disabled(),
                Select::make('status')
                    ->label(__('filament-url-watcher::filament-url-watcher.fields.status'))
                    ->options(collect(UrlWatchStatus::cases())->mapWithKeys(fn (UrlWatchStatus $case) => [$case->value => $case->label()])->all())
                    ->required(),
                TextInput::make('count')->label(__('filament-url-watcher::filament-url-watcher.fields.count'))->numeric()->disabled(),
                DateTimePicker::make('first_seen_at')->label(__('filament-url-watcher::filament-url-watcher.fields.first_seen_at'))->disabled(),
                DateTimePicker::make('last_seen_at')->label(__('filament-url-watcher::filament-url-watcher.fields.last_seen_at'))->disabled(),
                DateTimePicker::make('notified_at')->label(__('filament-url-watcher::filament-url-watcher.fields.notified_at')),
                KeyValue::make('meta')->label(__('filament-url-watcher::filament-url-watcher.fields.meta'))->disabled()->columnSpanFull(),
            ]),
        ]);
    }
}
