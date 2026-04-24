<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Support\Filament;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

final class BotFilterSettingsFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.capture.title'))
                ->description(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.capture.description'))
                ->schema([
                    Grid::make(2)->schema([
                        Toggle::make('capture_enabled')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.capture_enabled'))
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.capture_enabled')),
                        Toggle::make('capture_exceptions')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.capture_exceptions'))
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.capture_exceptions')),
                        CheckboxList::make('capture_statuses')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.capture_statuses'))
                            ->options([
                                404 => __('filament-bot-filter::filament-bot-filter.pages.settings.statuses.404'),
                                405 => __('filament-bot-filter::filament-bot-filter.pages.settings.statuses.405'),
                            ])
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.capture_statuses'))
                            ->columnSpanFull(),
                    ]),
                ]),
            Section::make(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.ignore.title'))
                ->description(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.ignore.description'))
                ->schema([
                    Grid::make(2)->schema([
                        TagsInput::make('ignore_paths')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.ignore_paths'))
                            ->separator(null)
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.ignore_paths')),
                        TagsInput::make('ignore_hosts')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.ignore_hosts'))
                            ->separator(null)
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.ignore_hosts')),
                        TagsInput::make('ignore_panels')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.ignore_panels'))
                            ->separator(null)
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.ignore_panels')),
                        TagsInput::make('ignore_methods')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.ignore_methods'))
                            ->separator(null)
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.ignore_methods')),
                        TagsInput::make('ignore_exception_classes')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.ignore_exception_classes'))
                            ->separator(null)
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.ignore_exception_classes'))
                            ->columnSpanFull(),
                    ]),
                ]),
            Section::make(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.notifications.title'))
                ->description(__('filament-bot-filter::filament-bot-filter.pages.settings.sections.notifications.description'))
                ->schema([
                    Grid::make(2)->schema([
                        Toggle::make('notifications_enabled')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notifications_enabled'))
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notifications_enabled')),
                        Toggle::make('show_widgets')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.show_widgets'))
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.show_widgets')),
                        Select::make('notification_mode')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notification_mode'))
                            ->options([
                                'default' => __('filament-bot-filter::filament-bot-filter.pages.settings.notification_modes.default'),
                                'custom' => __('filament-bot-filter::filament-bot-filter.pages.settings.notification_modes.custom'),
                            ])
                            ->required()
                            ->live()
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notification_mode')),
                        TextInput::make('notification_title')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notification_title'))
                            ->placeholder(__('filament-bot-filter::filament-bot-filter.pages.settings.placeholders.notification_title'))
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'default')
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notification_title'))
                            ->columnSpanFull(),
                        Textarea::make('notification_intro')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notification_intro'))
                            ->placeholder(__('filament-bot-filter::filament-bot-filter.pages.settings.placeholders.notification_intro'))
                            ->rows(5)
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'default')
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notification_intro'))
                            ->columnSpanFull(),
                        TextInput::make('custom_notification_class')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.custom_notification_class'))
                            ->placeholder('App\\Notifications\\BotProbeDetectedNotification')
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'custom')
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.custom_notification_class')),
                        TextInput::make('notification_mail')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notification_mail'))
                            ->email()
                            ->placeholder('contact@proov-it.io')
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notification_mail')),
                        TextInput::make('notification_route')
                            ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.fields.notification_route'))
                            ->placeholder('contact@proov-it.io')
                            ->helperText(__('filament-bot-filter::filament-bot-filter.pages.settings.helpers.notification_route')),
                    ]),
                ]),
        ]);
    }
}
