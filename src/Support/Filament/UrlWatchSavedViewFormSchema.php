<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class UrlWatchSavedViewFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('filament-url-watcher::filament-url-watcher.saved_views.sections.metadata.title'))
                ->description(__('filament-url-watcher::filament-url-watcher.saved_views.sections.metadata.description'))
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.name'))
                            ->required()
                            ->maxLength(255),
                        Select::make('panel')
                            ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.panel'))
                            ->options(self::panelOptions())
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.saved_views.placeholders.panel')),
                        Textarea::make('description')
                            ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.description'))
                            ->rows(4)
                            ->columnSpanFull(),
                        Checkbox::make('is_default')
                            ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.is_default')),
                    ]),
                ]),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private static function panelOptions(): array
    {
        return [
            '' => __('filament-url-watcher::filament-url-watcher.saved_views.placeholders.panel'),
            'admin' => __('filament-url-watcher::filament-url-watcher.table.panel.admin'),
            'manager' => __('filament-url-watcher::filament-url-watcher.table.panel.manager'),
            'b2b' => __('filament-url-watcher::filament-url-watcher.table.panel.b2b'),
            'other' => __('filament-url-watcher::filament-url-watcher.table.panel.other'),
        ];
    }
}
