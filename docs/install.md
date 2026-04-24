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

