<?php

return [
    'resources' => [
        'bot_probe' => [
            'singular' => 'Bot probe',
            'plural' => 'Bot probes',
            'navigation_group' => 'Security',
        ],
    ],
    'pages' => [
        'settings' => [
            'label' => 'Bot filter settings',
            'title' => 'Bot filter settings',
            'navigation_group' => 'Security',
            'sections' => [
                'capture' => [
                    'title' => 'Capture',
                    'description' => 'Choose which incidents should be captured and turned into bot probe records.',
                ],
                'ignore' => [
                    'title' => 'Ignore rules',
                    'description' => 'Configure paths, hosts and exceptions that should never create a probe.',
                ],
                'notifications' => [
                    'title' => 'Notifications and display',
                    'description' => 'Control probe notifications and whether widgets are shown in Filament.',
                ],
            ],
            'fields' => [
                'capture_enabled' => 'Enable capture',
                'capture_exceptions' => 'Capture thrown exceptions',
                'capture_statuses' => 'Captured HTTP statuses',
                'ignore_paths' => 'Ignored paths',
                'ignore_hosts' => 'Ignored hosts',
                'ignore_panels' => 'Ignored panels',
                'ignore_methods' => 'Ignored methods',
                'ignore_exception_classes' => 'Ignored exception classes',
                'notifications_enabled' => 'Enable notifications',
                'notification_mode' => 'Notification mode',
                'notification_mail' => 'Fallback notification email',
                'notification_route' => 'Notification route',
                'custom_notification_class' => 'Custom notification class',
                'show_widgets' => 'Show dashboard widgets',
            ],
            'statuses' => [
                '404' => '404 Not Found',
                '405' => '405 Method Not Allowed',
            ],
            'notification_modes' => [
                'default' => 'Use package notification',
                'custom' => 'Use custom application notification',
            ],
            'helpers' => [
                'capture_enabled' => 'When disabled, the middleware stays passive.',
                'capture_exceptions' => 'When enabled, thrown routing exceptions can be recorded too.',
                'capture_statuses' => 'These HTTP statuses are turned into probes when the response matches.',
                'ignore_paths' => 'Examples: robots.txt, wp-login.php, phpinfo, settings.ini.',
                'ignore_hosts' => 'Hosts or wildcard patterns that should be ignored.',
                'ignore_panels' => 'Panels such as admin, manager or b2b.',
                'ignore_methods' => 'HTTP verbs to skip, for example HEAD or OPTIONS.',
                'ignore_exception_classes' => 'Fully-qualified exception classes to ignore.',
                'notifications_enabled' => 'Turn off all notifications without disabling capture.',
                'notification_mode' => 'Default uses the package mail notification. Custom expects an application notification class.',
                'custom_notification_class' => 'Optional FQCN of a notification class that accepts a probe in its constructor.',
                'notification_mail' => 'Fallback email used for the on-demand notification route.',
                'notification_route' => 'Optional on-demand route target. Leave empty to use the fallback email.',
                'show_widgets' => 'Hide the dashboard widgets if you only want the resource table.',
            ],
            'actions' => [
                'save' => 'Save changes',
                'reset_defaults' => 'Reset defaults',
            ],
            'notifications' => [
                'saved' => [
                    'title' => 'Settings saved',
                ],
                'reset_defaults' => [
                    'title' => 'Defaults restored',
                ],
            ],
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
