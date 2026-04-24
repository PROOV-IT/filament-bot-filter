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
