<?php

return [
    'resources' => [
        'bot_probe' => [
            'singular' => 'Sonde bot',
            'plural' => 'Sondes bot',
            'navigation_group' => 'Sécurité',
        ],
        'saved_view' => [
            'singular' => 'Vue sauvegardée',
            'plural' => 'Vues sauvegardées',
            'navigation_group' => 'Sécurité',
        ],
    ],
    'pages' => [
        'settings' => [
            'label' => 'Réglages bot filter',
            'title' => 'Réglages bot filter',
            'navigation_group' => 'Sécurité',
            'sections' => [
                'capture' => [
                    'title' => 'Capture',
                    'description' => 'Choisissez quels incidents doivent être capturés et transformés en sondes bot.',
                ],
                'ignore' => [
                    'title' => 'Règles d’exclusion',
                    'description' => 'Configurez les chemins, hôtes et exceptions qui ne doivent jamais créer de sonde.',
                ],
                'notifications' => [
                    'title' => 'Notifications et affichage',
                    'description' => 'Gérez les notifications de sondes et l’affichage des widgets dans Filament.',
                ],
            ],
            'fields' => [
                'capture_enabled' => 'Activer la capture',
                'capture_exceptions' => 'Capturer les exceptions levées',
                'capture_statuses' => 'Statuts HTTP capturés',
                'ignore_paths' => 'Chemins exclus',
                'ignore_hosts' => 'Hôtes exclus',
                'ignore_panels' => 'Panels exclus',
                'ignore_methods' => 'Méthodes HTTP exclues',
                'ignore_exception_classes' => 'Classes d’exceptions exclues',
                'notifications_enabled' => 'Activer les notifications',
                'notification_mode' => 'Mode de notification',
                'notification_title' => 'Titre de la notification',
                'notification_intro' => 'Intro de la notification',
                'notification_mail' => 'Email de secours',
                'notification_route' => 'Route de notification',
                'custom_notification_class' => 'Classe de notification personnalisée',
                'show_widgets' => 'Afficher les widgets du tableau de bord',
            ],
            'statuses' => [
                '404' => '404 Non trouvé',
                '405' => '405 Méthode non autorisée',
            ],
            'notification_modes' => [
                'default' => 'Utiliser la notification du package',
                'custom' => 'Utiliser la notification de l’application',
            ],
            'helpers' => [
                'capture_enabled' => 'Désactivé, le middleware reste inactif.',
                'capture_exceptions' => 'Quand c’est activé, les exceptions de routage levées peuvent aussi être enregistrées.',
                'capture_statuses' => 'Ces statuts HTTP deviennent des sondes lorsque la réponse correspond.',
                'ignore_paths' => 'Exemples : robots.txt, wp-login.php, phpinfo, settings.ini.',
                'ignore_hosts' => 'Hôtes ou motifs globaux à ignorer.',
                'ignore_panels' => 'Panels comme admin, manager ou b2b.',
                'ignore_methods' => 'Verbes HTTP à ignorer, par exemple HEAD ou OPTIONS.',
                'ignore_exception_classes' => 'Classes d’exceptions totalement qualifiées à ignorer.',
                'notifications_enabled' => 'Coupe toutes les notifications sans désactiver la capture.',
                'notification_mode' => 'Le mode par défaut utilise la notification du package. Le mode personnalisé attend une classe de notification applicative.',
                'notification_title' => 'Utilisé uniquement par la notification du package comme sujet de l’email. Laissez vide pour conserver le sujet par défaut.',
                'notification_intro' => 'Lignes d’intro optionnelles affichées avant les détails de la sonde dans la notification du package.',
                'custom_notification_class' => 'FQCN facultatif d’une classe de notification qui accepte une sonde dans son constructeur.',
                'notification_mail' => 'Email de secours utilisé pour la route de notification on-demand.',
                'notification_route' => 'Cible optionnelle de la route on-demand. Laissez vide pour utiliser l’email de secours.',
                'show_widgets' => 'Masque les widgets si vous souhaitez seulement la table des sondes.',
            ],
            'placeholders' => [
                'notification_title' => 'Sonde bot détectée',
                'notification_intro' => 'Nous avons détecté une nouvelle sonde bot sur votre application.',
            ],
            'actions' => [
                'save' => 'Enregistrer',
                'reset_defaults' => 'Restaurer les valeurs par défaut',
            ],
            'notifications' => [
                'saved' => [
                    'title' => 'Réglages enregistrés',
                ],
                'reset_defaults' => [
                    'title' => 'Valeurs par défaut restaurées',
                ],
            ],
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
    'bulk_actions' => [
        'updated' => 'Mise à jour groupée terminée',
        'count' => ':count enregistrement(s) mis à jour.',
    ],
    'saved_views' => [
        'singular' => 'Vue sauvegardée',
        'plural' => 'Vues sauvegardées',
        'navigation_group' => 'Sécurité',
        'sections' => [
            'metadata' => [
                'title' => 'Métadonnées',
                'description' => 'Donnez un nom lisible à cette vue et une description optionnelle.',
            ],
        ],
        'fields' => [
            'name' => 'Nom',
            'description' => 'Description',
            'panel' => 'Panel',
            'is_default' => 'Vue par défaut',
            'search' => 'Recherche globale',
            'sort' => 'Tri',
            'filters' => 'Filtres',
            'column_searches' => 'Recherches de colonnes',
            'applied_count' => 'Nombre d’utilisations',
            'last_applied_at' => 'Dernière utilisation',
            'updated_at' => 'Modifié le',
            'saved_view' => 'Vue sauvegardée',
        ],
        'placeholders' => [
            'panel' => 'Tous les panels',
            'any' => 'Tous',
        ],
        'values' => [
            'yes' => 'Oui',
            'no' => 'Non',
        ],
        'actions' => [
            'save_current_view' => 'Enregistrer la vue courante',
            'load_view' => 'Charger une vue',
            'manage' => 'Gérer les vues',
        ],
        'notifications' => [
            'saved' => [
                'title' => 'Vue sauvegardée enregistrée',
            ],
            'loaded' => [
                'title' => 'Vue sauvegardée chargée',
            ],
        ],
        'scopes' => [
            'global' => 'Tous les panels',
        ],
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
