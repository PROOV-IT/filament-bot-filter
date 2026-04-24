# proovit/filament-bot-filter

Filament 5 admin plugin for ProovIT bot and probe monitoring.

## What it does

- exposes a Filament resource for bot probes
- provides table actions to classify incidents as bot, normal, or ignored
- ships with a detail page and editable status/classification form
- adds stats and trend widgets
- stays decoupled from the host app through the `proovit/laravel-bot-filter` core package
- only displays incidents already captured by the core middleware

## Install

```bash
composer require proovit/filament-bot-filter
```

You must also install and register `proovit/laravel-bot-filter` capture middleware for the plugin to show data.

## Documentation

- [Install](docs/install.md)
- [Configuration](docs/configuration.md)
- [Widgets](docs/widgets.md)
- [Release notes](docs/release-notes.md)
