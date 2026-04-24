<?php

return [
    'resources' => [
        'bot_probe' => [
            'singular' => 'Bot probe',
            'plural' => 'Bot probes',
            'navigation_group' => 'Security',
        ],
    ],
    'fields' => [
        'path' => 'Path',
        'normalized_path' => 'Normalized path',
        'host' => 'Host',
        'panel' => 'Panel',
        'exception_class' => 'Exception',
        'route_name' => 'Route name',
        'classification' => 'Classification',
        'suggested_classification' => 'Suggested classification',
        'status' => 'Status',
        'count' => 'Count',
        'first_seen_at' => 'First seen',
        'last_seen_at' => 'Last seen',
        'notified_at' => 'Notified',
        'meta' => 'Payload',
    ],
    'table' => [
        'panel' => [
            'admin' => 'Admin',
            'manager' => 'Manager',
            'b2b' => 'B2B',
            'other' => 'Other',
        ],
    ],
    'actions' => [
        'view' => 'View',
        'mark_bot' => 'Mark bot',
        'mark_normal' => 'Mark normal',
        'mark_ignored' => 'Ignore',
        'reset_review' => 'Reset review',
    ],
    'widgets' => [
        'stats' => [
            'heading' => 'Bot probes overview',
            'pending' => 'Pending',
            'bots' => 'Bots',
            'reviewed' => 'Reviewed',
            'today' => 'Today',
        ],
        'trend' => [
            'heading' => 'Probe trend',
            'probes' => 'Probes',
        ],
        'top_paths' => [
            'heading' => 'Top probe paths',
            'hits' => 'Hits',
        ],
    ],
];
