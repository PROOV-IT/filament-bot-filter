# Install

```bash
composer require proovit/filament-url-watcher
```

Register the plugin in your panel:

```php
use Proovit\FilamentUrlWatcher\FilamentUrlWatcherPlugin;

$panel->plugins([
    FilamentUrlWatcherPlugin::make(),
]);
```

Then make sure the core package `proovit/laravel-url-watcher` is installed and its middleware is prepended globally in `bootstrap/app.php`.

Sync the built-in operator presets into persistent saved views:

```bash
php artisan url-watcher:sync-default-views
```

The plugin registers:

- the URL watch resource
- the URL watch event history resource
- the URL watch saved views resource
- the URL watcher settings page
- the dashboard widgets when they are enabled in the runtime settings

The saved views flow now works on both:

- aggregated URL watches
- event history tables

The settings page also lets operators customize the subject and intro copy of the package notification when the default notification mode is used.

The URL watch resource provides:

- row actions to classify incidents quickly
- a direct history drill-down into detailed events
- bulk actions to classify multiple incidents at once
- header actions to save and load table views

Saved views persist the table search, sorting, filters and column searches so operators can switch between investigation presets with one click.

The settings page also exposes operator actions to:

- sync the built-in default views
- send the digest immediately
- run the retention command immediately

## Suggested scheduling

The Filament plugin does not schedule tasks itself. The host app should schedule the core commands, for example in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('url-watcher:digest')->hourly();
Schedule::command('url-watcher:prune')->dailyAt('02:00');
```

That keeps all operational behavior in the Laravel app while the plugin remains a cockpit for review and manual execution.
