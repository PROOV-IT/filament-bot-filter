<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Resources\UrlWatchResource\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;
use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchSavedViewResource;

final class ListUrlWatches extends ManageRecords
{
    protected static string $resource = UrlWatchResource::class;

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
                    $payload = UrlWatchSavedView::captureFromPageState([
                        'search' => $this->getTableSearch(),
                        'sort' => $this->tableSort,
                        'filters' => $this->tableDeferredFilters ?? $this->tableFilters ?? [],
                        'column_searches' => $this->tableColumnSearches ?? [],
                    ], $data['panel'] ?: (Filament::getCurrentPanel()?->getId()));
                    $payload['target'] = UrlWatchSavedView::TARGET_WATCHES;

                    $savedView = UrlWatchSavedView::query()->create(array_merge($payload, [
                        'name' => trim((string) $data['name']),
                        'description' => filled($data['description'] ?? null) ? trim((string) $data['description']) : null,
                        'is_default' => (bool) ($data['is_default'] ?? false),
                    ]));

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
                                ->forTarget(UrlWatchSavedView::TARGET_WATCHES)
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
                    $this->applySavedView($savedView);

                    Notification::make()
                        ->title(__('filament-url-watcher::filament-url-watcher.saved_views.notifications.loaded.title'))
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

    private function applySavedView(UrlWatchSavedView $savedView): void
    {
        $savedView->applyToPage($this);

        if (method_exists($this, 'getTable') && $this->getTable()->hasDeferredFilters() && method_exists($this, 'applyTableFilters')) {
            $this->applyTableFilters();
        }
    }
}
