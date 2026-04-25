# proovit/filament-url-watcher

Filament 5 admin plugin for ProovIT URL watcher monitoring.

## What it does

- exposes a Filament resource for aggregated URL watches
- exposes a Filament resource for detailed URL watch events
- adds a settings page to manage capture rules, ignore lists, and notification copy
- provides table actions to classify incidents as bot, normal, or ignored
- provides bulk classification actions, saved table views, and built-in operator presets for watches and events
- ships with a detail page and editable status/classification form
- adds stats, trend, top paths, and top hosts widgets
- stays decoupled from the host app through the `proovit/laravel-url-watcher` core package
- only displays incidents already captured by the core middleware

## Install

```bash
composer require proovit/filament-url-watcher
```

You must also install and register `proovit/laravel-url-watcher` capture middleware for the plugin to show data.
The plugin also exposes:

- a Filament settings page where you can toggle notifications, choose between default and custom notification classes, customize the package notification title and intro copy, manage rulesets, and manage the widget visibility
- digest and retention settings, including mail target, title, intro, recent event count, and pruning window
- a saved views resource for operator-defined investigation views
- built-in operator presets such as pending review, confirmed bots, recent 404s, and write attempts
- a sync command so built-in operator presets can also exist as persistent saved views
- row and bulk classification actions on the URL watch table

To persist the built-in operator presets as saved views that can be cloned and adjusted:

```bash
php artisan url-watcher:sync-default-views
```

## Documentation

- [Install](docs/install.md)
- [Configuration](docs/configuration.md)
- [Widgets](docs/widgets.md)
- [Release notes](docs/release-notes.md)
