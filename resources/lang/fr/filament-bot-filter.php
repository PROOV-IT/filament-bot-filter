<?php

return [
    'resources' => [
        'bot_probe' => [
            'singular' => 'Sonde bot',
            'plural' => 'Sondes bot',
            'navigation_group' => 'Sécurité',
        ],
    ],
    'fields' => [
        'path' => 'Chemin',
        'normalized_path' => 'Chemin normalisé',
        'host' => 'Hôte',
        'panel' => 'Panneau',
        'exception_class' => 'Exception',
        'route_name' => 'Nom de route',
        'classification' => 'Classification',
        'suggested_classification' => 'Classification suggérée',
        'status' => 'Statut',
        'count' => 'Compteur',
        'first_seen_at' => 'Première vue',
        'last_seen_at' => 'Dernière vue',
        'notified_at' => 'Notifié',
        'meta' => 'Données brutes',
    ],
    'table' => [
        'panel' => [
            'admin' => 'Admin',
            'manager' => 'Manager',
            'b2b' => 'B2B',
            'other' => 'Autre',
        ],
    ],
    'actions' => [
        'view' => 'Voir',
        'mark_bot' => 'Marquer bot',
        'mark_normal' => 'Marquer normal',
        'mark_ignored' => 'Ignorer',
        'reset_review' => 'Réinitialiser',
    ],
    'widgets' => [
        'stats' => [
            'heading' => 'Vue d’ensemble des sondes',
            'pending' => 'En attente',
            'bots' => 'Bots',
            'reviewed' => 'Révisés',
            'today' => 'Aujourd’hui',
        ],
        'trend' => [
            'heading' => 'Tendance des sondes',
            'probes' => 'Sondes',
        ],
        'top_paths' => [
            'heading' => 'Chemins les plus vus',
            'hits' => 'Occurrences',
        ],
    ],
];
