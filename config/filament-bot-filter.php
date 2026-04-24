<?php

return [
    'enabled' => env('FILAMENT_BOT_FILTER_ENABLED', true),
    'navigation_group' => env('FILAMENT_BOT_FILTER_NAVIGATION_GROUP', 'Security'),
    'navigation_icon' => env('FILAMENT_BOT_FILTER_NAVIGATION_ICON', 'heroicon-o-shield-exclamation'),
    'navigation_sort' => env('FILAMENT_BOT_FILTER_NAVIGATION_SORT', 99),
    'show_navigation' => env('FILAMENT_BOT_FILTER_SHOW_NAVIGATION', true),
    'show_widgets' => env('FILAMENT_BOT_FILTER_SHOW_WIDGETS', true),
];
