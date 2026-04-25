<?php

return [
    'enabled' => env('FILAMENT_URL_WATCHER_ENABLED', true),
    'navigation_group' => env('FILAMENT_URL_WATCHER_NAVIGATION_GROUP', 'Security'),
    'navigation_icon' => env('FILAMENT_URL_WATCHER_NAVIGATION_ICON', 'heroicon-o-shield-exclamation'),
    'navigation_sort' => env('FILAMENT_URL_WATCHER_NAVIGATION_SORT', 99),
    'show_navigation' => env('FILAMENT_URL_WATCHER_SHOW_NAVIGATION', true),
    'show_settings_navigation' => env('FILAMENT_URL_WATCHER_SHOW_SETTINGS_NAVIGATION', true),
    'settings_navigation_icon' => env('FILAMENT_URL_WATCHER_SETTINGS_NAVIGATION_ICON', 'heroicon-o-cog-6-tooth'),
    'settings_navigation_sort' => env('FILAMENT_URL_WATCHER_SETTINGS_NAVIGATION_SORT', 98),
    'show_saved_views_navigation' => env('FILAMENT_URL_WATCHER_SHOW_SAVED_VIEWS_NAVIGATION', true),
    'saved_views_navigation_icon' => env('FILAMENT_URL_WATCHER_SAVED_VIEWS_NAVIGATION_ICON', 'heroicon-o-book-open'),
    'saved_views_navigation_sort' => env('FILAMENT_URL_WATCHER_SAVED_VIEWS_NAVIGATION_SORT', 97),
    'show_history_navigation' => env('FILAMENT_URL_WATCHER_SHOW_HISTORY_NAVIGATION', true),
    'history_navigation_icon' => env('FILAMENT_URL_WATCHER_HISTORY_NAVIGATION_ICON', 'heroicon-o-clock'),
    'history_navigation_sort' => env('FILAMENT_URL_WATCHER_HISTORY_NAVIGATION_SORT', 98),
    'show_widgets' => env('FILAMENT_URL_WATCHER_SHOW_WIDGETS', true),
];
