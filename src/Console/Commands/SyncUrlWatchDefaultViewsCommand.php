<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Console\Commands;

use Illuminate\Console\Command;
use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\FilamentUrlWatcher\Support\Filament\UrlWatchDefaultViewPresets;

final class SyncUrlWatchDefaultViewsCommand extends Command
{
    protected $signature = 'url-watcher:sync-default-views';

    protected $description = 'Sync built-in URL watcher operator presets into saved views';

    public function handle(): int
    {
        $created = 0;
        $updated = 0;

        foreach (UrlWatchDefaultViewPresets::databaseRows() as $row) {
            $view = UrlWatchSavedView::query()->firstOrNew([
                'preset_key' => $row['preset_key'],
            ]);

            $isExisting = $view->exists;

            $view->fill($row);
            $view->save();

            if ($isExisting) {
                $updated++;
            } else {
                $created++;
            }
        }

        $this->info(sprintf('Default views synced. Created: %d, updated: %d.', $created, $updated));

        return self::SUCCESS;
    }
}
