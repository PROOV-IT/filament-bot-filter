<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

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
use Proovit\UrlWatcher\Contracts\UrlWatcherSettingsRepositoryInterface;

final class UrlWatcherSettingsFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.capture.title'))
                ->description(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.capture.description'))
                ->schema([
                    Grid::make(2)->schema([
                        Toggle::make('capture_enabled')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.capture_enabled'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.capture_enabled')),
                        Toggle::make('capture_exceptions')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.capture_exceptions'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.capture_exceptions')),
                        CheckboxList::make('capture_statuses')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.capture_statuses'))
                            ->options([
                                404 => __('filament-url-watcher::filament-url-watcher.pages.settings.statuses.404'),
                                405 => __('filament-url-watcher::filament-url-watcher.pages.settings.statuses.405'),
                            ])
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.capture_statuses'))
                            ->columnSpanFull(),
                    ]),
                ]),
            Section::make(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.ignore.title'))
                ->description(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.ignore.description'))
                ->schema([
                    Grid::make(2)->schema([
                        TagsInput::make('ignore_paths')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.ignore_paths'))
                            ->separator(null)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.ignore_paths')),
                        TagsInput::make('ignore_hosts')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.ignore_hosts'))
                            ->separator(null)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.ignore_hosts')),
                        TagsInput::make('ignore_panels')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.ignore_panels'))
                            ->separator(null)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.ignore_panels')),
                        TagsInput::make('ignore_methods')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.ignore_methods'))
                            ->separator(null)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.ignore_methods')),
                        TagsInput::make('ignore_exception_classes')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.ignore_exception_classes'))
                            ->separator(null)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.ignore_exception_classes'))
                            ->columnSpanFull(),
                    ]),
                ]),
            Section::make(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.notifications.title'))
                ->description(__('filament-url-watcher::filament-url-watcher.pages.settings.sections.notifications.description'))
                ->schema([
                    Grid::make(2)->schema([
                        Toggle::make('notifications_enabled')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notifications_enabled'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notifications_enabled')),
                        Toggle::make('show_widgets')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.show_widgets'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.show_widgets')),
                        Select::make('notification_mode')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notification_mode'))
                            ->options([
                                'default' => __('filament-url-watcher::filament-url-watcher.pages.settings.notification_modes.default'),
                                'custom' => __('filament-url-watcher::filament-url-watcher.pages.settings.notification_modes.custom'),
                            ])
                            ->required()
                            ->live()
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notification_mode')),
                        Select::make('active_ruleset')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.active_ruleset'))
                            ->options(self::rulesetOptions())
                            ->searchable()
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.active_ruleset'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.active_ruleset'))
                            ->columnSpanFull(),
                        TextInput::make('notification_title')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notification_title'))
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.notification_title'))
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'default')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notification_title'))
                            ->columnSpanFull(),
                        Textarea::make('notification_intro')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notification_intro'))
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.notification_intro'))
                            ->rows(5)
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'default')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notification_intro'))
                            ->columnSpanFull(),
                        TextInput::make('custom_notification_class')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.custom_notification_class'))
                            ->placeholder('App\\Notifications\\UrlWatchDetectedNotification')
                            ->visible(fn (Get $get): bool => $get('notification_mode') === 'custom')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.custom_notification_class')),
                        TextInput::make('notification_mail')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notification_mail'))
                            ->email()
                            ->placeholder('contact@proov-it.io')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notification_mail')),
                        TextInput::make('notification_route')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.notification_route'))
                            ->placeholder('contact@proov-it.io')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.notification_route')),
                        Toggle::make('digest_enabled')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_enabled'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_enabled')),
                        TextInput::make('digest_mail')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_mail'))
                            ->email()
                            ->placeholder('contact@proov-it.io')
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_mail')),
                        TextInput::make('digest_title')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_title'))
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.digest_title'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_title')),
                        Textarea::make('digest_intro')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_intro'))
                            ->placeholder(__('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.digest_intro'))
                            ->rows(4)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_intro'))
                            ->columnSpanFull(),
                        TextInput::make('digest_window_hours')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_window_hours'))
                            ->numeric()
                            ->minValue(1)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_window_hours')),
                        TextInput::make('digest_recent_events_limit')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_recent_events_limit'))
                            ->numeric()
                            ->minValue(1)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_recent_events_limit')),
                        Toggle::make('digest_notify_when_empty')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.digest_notify_when_empty'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.digest_notify_when_empty')),
                        Toggle::make('retention_enabled')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.retention_enabled'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.retention_enabled')),
                        TextInput::make('retention_days')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.retention_days'))
                            ->numeric()
                            ->minValue(1)
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.retention_days')),
                        Toggle::make('retention_prune_aggregates')
                            ->label(__('filament-url-watcher::filament-url-watcher.pages.settings.fields.retention_prune_aggregates'))
                            ->helperText(__('filament-url-watcher::filament-url-watcher.pages.settings.helpers.retention_prune_aggregates')),
                    ]),
                ]),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private static function rulesetOptions(): array
    {
        $options = [
            '' => __('filament-url-watcher::filament-url-watcher.pages.settings.placeholders.active_ruleset'),
        ];

        foreach (app(UrlWatcherSettingsRepositoryInterface::class)->rulesets() as $ruleset) {
            $key = (string) ($ruleset['key'] ?? '');
            $label = (string) ($ruleset['label'] ?? $key);

            if ($key === '') {
                continue;
            }

            $options[$key] = $label;
        }

        return $options;
    }
}
