<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class UrlWatchSavedView extends Model
{
    use HasUuids;

    public const TARGET_WATCHES = 'watches';

    public const TARGET_EVENTS = 'events';

    protected $guarded = [];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'filters' => 'array',
        'column_searches' => 'array',
        'is_default' => 'bool',
        'applied_count' => 'int',
        'last_applied_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return (string) config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');
    }

    public function getConnectionName(): ?string
    {
        return config('filament-url-watcher.saved_views.connection') ?: parent::getConnectionName();
    }

    /**
     * @param  array<string, mixed>  $state
     * @return array<string, mixed>
     */
    public static function captureFromPageState(array $state, ?string $panel = null, string $target = self::TARGET_WATCHES): array
    {
        $sort = trim((string) ($state['sort'] ?? ''));
        $sortColumn = null;
        $sortDirection = null;

        if ($sort !== '') {
            $sortColumn = (string) Str::before($sort, ':');
            $sortDirection = Str::contains($sort, ':') ? (string) Str::after($sort, ':') : 'asc';
        }

        return [
            'target' => in_array($target, [self::TARGET_WATCHES, self::TARGET_EVENTS], true) ? $target : self::TARGET_WATCHES,
            'panel' => filled($panel) ? trim((string) $panel) : null,
            'search' => filled($state['search'] ?? null) ? trim((string) $state['search']) : null,
            'sort_column' => filled($sortColumn) ? $sortColumn : null,
            'sort_direction' => in_array($sortDirection, ['asc', 'desc'], true) ? $sortDirection : null,
            'filters' => (array) ($state['filters'] ?? []),
            'column_searches' => (array) ($state['column_searches'] ?? []),
        ];
    }

    public function applyToPage(object $page): void
    {
        if (property_exists($page, 'tableFilters')) {
            $page->tableFilters = $this->filters ?? [];
        }

        if (property_exists($page, 'tableDeferredFilters')) {
            $page->tableDeferredFilters = $this->filters ?? [];
        }

        if (property_exists($page, 'tableColumnSearches')) {
            $page->tableColumnSearches = $this->column_searches ?? [];
        }

        if (property_exists($page, 'tableSearch')) {
            $page->tableSearch = (string) ($this->search ?? '');
        }

        if (property_exists($page, 'tableSort')) {
            $page->tableSort = filled($this->sort_column)
                ? sprintf('%s:%s', $this->sort_column, $this->sort_direction ?: 'asc')
                : null;
        }

        if (method_exists($page, 'updatedTableFilters')) {
            $page->updatedTableFilters();
        }

        if (method_exists($page, 'updatedTableColumnSearches')) {
            $page->updatedTableColumnSearches($page->tableColumnSearches ?? []);
        }

        if (method_exists($page, 'updatedTableSearch')) {
            $page->updatedTableSearch();
        }

        if (method_exists($page, 'updatedTableSort')) {
            $page->updatedTableSort();
        }

        if (method_exists($page, 'resetPage')) {
            $page->resetPage();
        }
    }

    public function markAsApplied(): self
    {
        $this->applied_count = (int) $this->applied_count + 1;
        $this->last_applied_at = now();
        $this->save();

        return $this;
    }

    public function getFiltersSummaryAttribute(): string
    {
        $filters = is_array($this->filters) ? array_filter($this->filters, static fn ($value): bool => filled($value)) : [];

        return count($filters) > 0
            ? __('filament-url-watcher::filament-url-watcher.saved_views.summaries.filters', ['count' => count($filters)])
            : __('filament-url-watcher::filament-url-watcher.saved_views.summaries.empty');
    }

    public function getColumnSearchesSummaryAttribute(): string
    {
        $searches = is_array($this->column_searches) ? array_filter($this->column_searches, static fn ($value): bool => filled($value)) : [];

        return count($searches) > 0
            ? __('filament-url-watcher::filament-url-watcher.saved_views.summaries.column_searches', ['count' => count($searches)])
            : __('filament-url-watcher::filament-url-watcher.saved_views.summaries.empty');
    }

    public function getSortSummaryAttribute(): string
    {
        if (! filled($this->sort_column)) {
            return __('filament-url-watcher::filament-url-watcher.saved_views.summaries.empty');
        }

        return __('filament-url-watcher::filament-url-watcher.saved_views.summaries.sort', [
            'column' => $this->sort_column,
            'direction' => $this->sort_direction ?: 'asc',
        ]);
    }

    public function scopeForPanel(Builder $query, ?string $panel = null): Builder
    {
        return $query->when(filled($panel), static fn ($query) => $query->where('panel', $panel));
    }

    public function scopeForTarget(Builder $query, string $target): Builder
    {
        return $query->where('target', $target);
    }

    public function getPanelLabelAttribute(): string
    {
        return filled($this->panel) ? (string) $this->panel : __('filament-url-watcher::filament-url-watcher.saved_views.scopes.global');
    }

    public function getTargetLabelAttribute(): string
    {
        return match ((string) $this->target) {
            self::TARGET_EVENTS => __('filament-url-watcher::filament-url-watcher.saved_views.targets.events'),
            default => __('filament-url-watcher::filament-url-watcher.saved_views.targets.watches'),
        };
    }
}
