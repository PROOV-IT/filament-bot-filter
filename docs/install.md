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

The plugin registers:

- the URL watch resource
- the URL watch event history resource
- the URL watch saved views resource
- the URL watcher settings page
- the dashboard widgets when they are enabled in the runtime settings

The settings page also lets operators customize the subject and intro copy of the package notification when the default notification mode is used.

The URL watch resource provides:

- row actions to classify incidents quickly
- a direct history drill-down into detailed events
- bulk actions to classify multiple incidents at once
- header actions to save and load table views

Saved views persist the table search, sorting, filters and column searches so operators can switch between investigation presets with one click.
