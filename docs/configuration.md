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
- `show_widgets`

The plugin does not capture requests on its own. It only provides the admin UI for incidents stored by `proovit/laravel-bot-filter`.

The settings page writes to the runtime settings table from the core package. That means the Filament UI can enable or disable notifications, switch between default and custom notification modes, and hide the widgets without editing config files.
