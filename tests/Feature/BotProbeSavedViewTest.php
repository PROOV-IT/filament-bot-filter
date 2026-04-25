<?php

declare(strict_types=1);

use Proovit\FilamentBotFilter\Models\BotProbeSavedView;

it('captures a saved view state from table filters and sorting', function (): void {
    $payload = BotProbeSavedView::captureFromPageState([
        'search' => ' robots ',
        'sort' => 'last_seen_at:desc',
        'filters' => ['status' => ['value' => 'pending']],
        'column_searches' => ['host' => 'example.com'],
    ], 'admin');

    expect($payload)->toMatchArray([
        'panel' => 'admin',
        'search' => 'robots',
        'sort_column' => 'last_seen_at',
        'sort_direction' => 'desc',
        'filters' => ['status' => ['value' => 'pending']],
        'column_searches' => ['host' => 'example.com'],
    ]);
});

it('applies a saved view to a table-like page object', function (): void {
    $view = BotProbeSavedView::query()->create([
        'name' => 'Admin view',
        'panel' => 'admin',
        'search' => 'robots',
        'sort_column' => 'last_seen_at',
        'sort_direction' => 'desc',
        'filters' => ['status' => ['value' => 'pending']],
        'column_searches' => ['host' => 'example.com'],
        'is_default' => true,
    ]);

    $page = new class () {
        public ?array $tableFilters = null;
        public ?array $tableDeferredFilters = null;
        public array $tableColumnSearches = [];
        public string $tableSearch = '';
        public ?string $tableSort = null;
        public int $resetPageCalls = 0;
        public int $updatedFiltersCalls = 0;
        public int $updatedSearchCalls = 0;
        public int $updatedSortCalls = 0;
        public int $updatedColumnSearchesCalls = 0;

        public function updatedTableFilters(): void
        {
            $this->updatedFiltersCalls++;
        }

        public function updatedTableSearch(): void
        {
            $this->updatedSearchCalls++;
        }

        public function updatedTableSort(): void
        {
            $this->updatedSortCalls++;
        }

        public function updatedTableColumnSearches($value = null, ?string $key = null): void
        {
            $this->updatedColumnSearchesCalls++;
        }

        public function resetPage(): void
        {
            $this->resetPageCalls++;
        }
    };

    $view->applyToPage($page);

    expect($page->tableFilters)->toBe(['status' => ['value' => 'pending']])
        ->and($page->tableColumnSearches)->toBe(['host' => 'example.com'])
        ->and($page->tableSearch)->toBe('robots')
        ->and($page->tableSort)->toBe('last_seen_at:desc')
        ->and($page->updatedFiltersCalls)->toBeGreaterThan(0)
        ->and($page->updatedSearchCalls)->toBeGreaterThan(0)
        ->and($page->updatedSortCalls)->toBeGreaterThan(0)
        ->and($page->updatedColumnSearchesCalls)->toBeGreaterThan(0)
        ->and($page->resetPageCalls)->toBeGreaterThan(0);
});
