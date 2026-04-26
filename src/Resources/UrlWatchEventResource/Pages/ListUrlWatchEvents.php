<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchDefaultViewPresets;

final class ListUrlWatchEvents extends ListRecords
{
    protected static string $resource = UrlWatchEventResource::class;

    public function mount(): void
    {
        parent::mount();

        $search = trim((string) request()->query('search', ''));
        $date = trim((string) request()->query('occurred_on', ''));
        $presetKey = request()->query('preset');

        if (filled($presetKey)) {
            $preset = UrlWatchDefaultViewPresets::find(UrlWatchSavedView::TARGET_EVENTS, (string) $presetKey);

            if ($preset !== null) {
                UrlWatchSavedView::applyStateToPage($preset['state'], $this);
            }
        }

        if ($search !== '') {
            $this->tableSearch = $search;
        }

        if ($date !== '') {
            $filters = $this->tableDeferredFilters ?? $this->tableFilters ?? [];
            $filters['occurred_on'] = [
                'occurred_from' => $date,
                'occurred_until' => $date,
            ];

            $this->tableFilters = $filters;
            $this->tableDeferredFilters = $filters;
        }

        if ((filled($presetKey) || $search !== '' || $date !== '') && method_exists($this, 'getTable') && $this->getTable()->hasDeferredFilters() && method_exists($this, 'applyTableFilters')) {
            $this->applyTableFilters();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save_view')
                ->label(__('filament-url-watcher::filament-url-watcher.saved_views.actions.save_current_view'))
                ->icon('heroicon-o-bookmark')
                ->color('primary')
                ->modalWidth(Width::Large)
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.name'))
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.description'))
                        ->rows(4)
                        ->columnSpanFull(),
                    Select::make('panel')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.panel'))
                        ->options([
                            '' => __('filament-url-watcher::filament-url-watcher.saved_views.placeholders.panel'),
                            'admin' => __('filament-url-watcher::filament-url-watcher.table.panel.admin'),
                            'manager' => __('filament-url-watcher::filament-url-watcher.table.panel.manager'),
                            'b2b' => __('filament-url-watcher::filament-url-watcher.table.panel.b2b'),
                            'other' => __('filament-url-watcher::filament-url-watcher.table.panel.other'),
                        ])
                        ->default(fn (): ?string => Filament::getCurrentPanel()?->getId())
                        ->placeholder(__('filament-url-watcher::filament-url-watcher.saved_views.placeholders.panel')),
                    Checkbox::make('is_default')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.is_default')),
                ])
                ->action(function (array $data): void {
                    $savedView = UrlWatchSavedView::query()->create(array_merge(
                        UrlWatchSavedView::captureFromPageState([
                            'search' => $this->getTableSearch(),
                            'sort' => $this->tableSort,
                            'filters' => $this->tableDeferredFilters ?? $this->tableFilters ?? [],
                            'column_searches' => $this->tableColumnSearches ?? [],
                        ], $data['panel'] ?: (Filament::getCurrentPanel()?->getId()), UrlWatchSavedView::TARGET_EVENTS),
                        [
                            'name' => trim((string) $data['name']),
                            'description' => filled($data['description'] ?? null) ? trim((string) $data['description']) : null,
                            'is_default' => (bool) ($data['is_default'] ?? false),
                        ],
                    ));

                    if ($savedView->is_default) {
                        UrlWatchSavedView::query()
                            ->whereKeyNot($savedView->getKey())
                            ->where('panel', $savedView->panel)
                            ->where('target', $savedView->target)
                            ->update(['is_default' => false]);
                    }

                    Notification::make()
                        ->title(__('filament-url-watcher::filament-url-watcher.saved_views.notifications.saved.title'))
                        ->success()
                        ->send();
                }),
            Action::make('load_view')
                ->label(__('filament-url-watcher::filament-url-watcher.saved_views.actions.load_view'))
                ->icon('heroicon-o-folder-open')
                ->color('gray')
                ->modalWidth(Width::Medium)
                ->schema([
                    Select::make('saved_view_id')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.saved_view'))
                        ->options(function (): array {
                            $panelId = Filament::getCurrentPanel()?->getId();

                            return UrlWatchSavedView::query()
                                ->forTarget(UrlWatchSavedView::TARGET_EVENTS)
                                ->when(filled($panelId), function ($query) use ($panelId): void {
                                    $query->where(function ($query) use ($panelId): void {
                                        $query->whereNull('panel')->orWhere('panel', $panelId);
                                    });
                                })
                                ->orderByDesc('is_default')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all();
                        })
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $savedView = UrlWatchSavedView::query()->findOrFail($data['saved_view_id']);
                    $savedView->markAsApplied();
                    $savedView->applyToPage($this);

                    if (method_exists($this, 'getTable') && $this->getTable()->hasDeferredFilters() && method_exists($this, 'applyTableFilters')) {
                        $this->applyTableFilters();
                    }

                    Notification::make()
                        ->title(__('filament-url-watcher::filament-url-watcher.saved_views.notifications.loaded.title'))
                        ->success()
                        ->send();
                }),
            Action::make('load_preset')
                ->label(__('filament-url-watcher::filament-url-watcher.saved_views.actions.load_preset'))
                ->icon('heroicon-o-sparkles')
                ->color('gray')
                ->modalWidth(Width::Medium)
                ->schema([
                    Select::make('preset_key')
                        ->label(__('filament-url-watcher::filament-url-watcher.saved_views.fields.preset'))
                        ->options(UrlWatchDefaultViewPresets::optionsForTarget(
                            UrlWatchSavedView::TARGET_EVENTS,
                            Filament::getCurrentPanel()?->getId(),
                        ))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $preset = UrlWatchDefaultViewPresets::find(UrlWatchSavedView::TARGET_EVENTS, (string) $data['preset_key']);

                    if ($preset === null) {
                        Notification::make()
                            ->title(__('filament-url-watcher::filament-url-watcher.saved_views.notifications.missing_preset.title'))
                            ->danger()
                            ->send();

                        return;
                    }

                    UrlWatchSavedView::applyStateToPage($preset['state'], $this);

                    if (method_exists($this, 'getTable') && $this->getTable()->hasDeferredFilters() && method_exists($this, 'applyTableFilters')) {
                        $this->applyTableFilters();
                    }

                    Notification::make()
                        ->title(__('filament-url-watcher::filament-url-watcher.saved_views.notifications.loaded_preset.title', ['name' => $preset['name']]))
                        ->success()
                        ->send();
                }),
            Action::make('manage_saved_views')
                ->label(__('filament-url-watcher::filament-url-watcher.saved_views.actions.manage'))
                ->icon('heroicon-o-book-open')
                ->color('gray')
                ->url(UrlWatchSavedViewResource::getUrl()),
        ];
    }
}
