# Configuration

The plugin reads `config/filament-bot-filter.php`.

Useful keys:

- `navigation_group`
- `navigation_icon`
- `navigation_sort`
- `show_navigation`
- `show_settings_navigation`
- `settings_navigation_icon`
- `settings_navigation_sort`
- `show_saved_views_navigation`
- `saved_views_navigation_icon`
- `saved_views_navigation_sort`
- `show_widgets`

The plugin does not capture requests on its own. It only provides the admin UI for incidents stored by `proovit/laravel-bot-filter`.

The settings page writes to the runtime settings table from the core package. That means the Filament UI can enable or disable notifications, switch between default and custom notification modes, and hide the widgets without editing config files.

When `notification_mode` is `default`, the settings page also controls the package notification subject (`notification_title`) and the intro copy displayed before the probe details (`notification_intro`).

The same settings page also controls the digest notification:

- `digest_enabled`
- `digest_mail`
- `digest_title`
- `digest_intro`
- `digest_window_hours`
- `digest_notify_when_empty`

The bot probe resource exposes saved views for operators. A saved view stores:

- global search
- sorting
- table filters
- column searches

Saved views are managed from the dedicated saved views resource and can be loaded from the bot probe table header actions.
