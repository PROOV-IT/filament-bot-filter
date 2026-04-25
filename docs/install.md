# Install

```bash
composer require proovit/filament-bot-filter
```

Register the plugin in your panel:

```php
use Proovit\FilamentBotFilter\FilamentBotFilterPlugin;

$panel->plugins([
    FilamentBotFilterPlugin::make(),
]);
```

Then make sure the core package `proovit/laravel-bot-filter` is installed and its middleware is prepended globally in `bootstrap/app.php`.

The plugin registers:

- the bot probe resource
- the bot probe saved views resource
- the bot filter settings page
- the dashboard widgets when they are enabled in the runtime settings

The settings page also lets operators customize the subject and intro copy of the package notification when the default notification mode is used.

The bot probe resource provides:

- row actions to classify probes quickly
- bulk actions to classify multiple probes at once
- header actions to save and load table views

Saved views persist the table search, sorting, filters and column searches so operators can switch between investigation presets with one click.
