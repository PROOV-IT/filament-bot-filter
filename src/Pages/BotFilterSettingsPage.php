<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Proovit\BotFilter\Contracts\BotFilterSettingsRepositoryInterface;
use Proovit\BotFilter\Models\BotFilterSetting;
use Proovit\FilamentBotFilter\Support\Filament\BotFilterSettingsFormSchema;
use UnitEnum;

final class BotFilterSettingsPage extends Page
{
    protected static ?string $slug = 'security/bot-filter/settings';

    protected string $view = 'filament-panels::pages.page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->settingsState());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->columns(2);
    }

    public function form(Schema $schema): Schema
    {
        return BotFilterSettingsFormSchema::make($schema);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-bot-filter::filament-bot-filter.pages.settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-bot-filter::filament-bot-filter.pages.settings.label');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('filament-bot-filter::filament-bot-filter.pages.settings.navigation_group');
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return (string) config('filament-bot-filter.settings_navigation_icon', 'heroicon-o-cog-6-tooth');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) config('filament-bot-filter.settings_navigation_sort', 98);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-bot-filter.show_settings_navigation', true);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.actions.save'))
                ->submit('save')
                ->keyBindings(['mod+s']),
            Action::make('reset_defaults')
                ->label(__('filament-bot-filter::filament-bot-filter.pages.settings.actions.reset_defaults'))
                ->color('gray')
                ->requiresConfirmation()
                ->action('resetDefaults'),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    protected function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions())
                    ->alignment($this->getFormActionsAlignment())
                    ->fullWidth($this->hasFullWidthFormActions())
                    ->sticky($this->areFormActionsSticky())
                    ->key('form-actions'),
            ]);
    }

    public function save(): void
    {
        $settings = $this->settingsRepository()->update($this->normalizeSettingsState($this->form->getState()));

        $this->form->fill($this->settingsState($settings));

        Notification::make()
            ->title(__('filament-bot-filter::filament-bot-filter.pages.settings.notifications.saved.title'))
            ->success()
            ->send();
    }

    public function resetDefaults(): void
    {
        $settings = $this->settingsRepository()->reset();

        $this->form->fill($this->settingsState($settings));

        Notification::make()
            ->title(__('filament-bot-filter::filament-bot-filter.pages.settings.notifications.reset_defaults.title'))
            ->warning()
            ->send();
    }

    /**
     * @return array<string, mixed>
     */
    private function settingsState(?BotFilterSetting $settings = null): array
    {
        $settings ??= $this->settingsRepository()->settings();

        return [
            'capture_enabled' => (bool) $settings->capture_enabled,
            'capture_exceptions' => (bool) $settings->capture_exceptions,
            'capture_statuses' => array_values(array_map(static fn ($value): int => (int) $value, (array) $settings->capture_statuses)),
            'ignore_paths' => array_values(array_filter(array_map(static fn ($value): string => trim((string) $value), (array) $settings->ignore_paths))),
            'ignore_hosts' => array_values(array_filter(array_map(static fn ($value): string => trim((string) $value), (array) $settings->ignore_hosts))),
            'ignore_panels' => array_values(array_filter(array_map(static fn ($value): string => trim((string) $value), (array) $settings->ignore_panels))),
            'ignore_methods' => array_values(array_filter(array_map(static fn ($value): string => trim((string) $value), (array) $settings->ignore_methods))),
            'ignore_exception_classes' => array_values(array_filter(array_map(static fn ($value): string => trim((string) $value), (array) $settings->ignore_exception_classes))),
            'notifications_enabled' => (bool) $settings->notifications_enabled,
            'notification_mode' => (string) $settings->notification_mode,
            'notification_title' => (string) ($settings->notification_title ?? ''),
            'notification_intro' => (string) ($settings->notification_intro ?? ''),
            'notification_mail' => (string) ($settings->notification_mail ?? ''),
            'notification_route' => (string) ($settings->notification_route ?? ''),
            'custom_notification_class' => (string) ($settings->custom_notification_class ?? ''),
            'show_widgets' => (bool) $settings->show_widgets,
        ];
    }

    /**
     * @param  array<string, mixed>  $state
     * @return array<string, mixed>
     */
    private function normalizeSettingsState(array $state): array
    {
        $normalizeList = static function (mixed $values): array {
            return array_values(array_filter(array_map(
                static fn ($value): string => trim((string) $value),
                (array) $values,
            )));
        };

        return [
            'capture_enabled' => (bool) ($state['capture_enabled'] ?? false),
            'capture_exceptions' => (bool) ($state['capture_exceptions'] ?? false),
            'capture_statuses' => array_values(array_map(
                static fn ($value): int => (int) $value,
                (array) ($state['capture_statuses'] ?? []),
            )),
            'ignore_paths' => $normalizeList($state['ignore_paths'] ?? []),
            'ignore_hosts' => $normalizeList($state['ignore_hosts'] ?? []),
            'ignore_panels' => $normalizeList($state['ignore_panels'] ?? []),
            'ignore_methods' => $normalizeList($state['ignore_methods'] ?? []),
            'ignore_exception_classes' => $normalizeList($state['ignore_exception_classes'] ?? []),
            'notifications_enabled' => (bool) ($state['notifications_enabled'] ?? false),
            'notification_mode' => in_array(($state['notification_mode'] ?? 'default'), ['default', 'custom'], true) ? (string) $state['notification_mode'] : 'default',
            'notification_title' => filled($state['notification_title'] ?? null) ? trim((string) $state['notification_title']) : null,
            'notification_intro' => filled($state['notification_intro'] ?? null) ? trim((string) $state['notification_intro']) : null,
            'notification_mail' => filled($state['notification_mail'] ?? null) ? trim((string) $state['notification_mail']) : null,
            'notification_route' => filled($state['notification_route'] ?? null) ? trim((string) $state['notification_route']) : null,
            'custom_notification_class' => filled($state['custom_notification_class'] ?? null) ? trim((string) $state['custom_notification_class']) : null,
            'show_widgets' => (bool) ($state['show_widgets'] ?? false),
        ];
    }

    private function settingsRepository(): BotFilterSettingsRepositoryInterface
    {
        return app(BotFilterSettingsRepositoryInterface::class);
    }
}
