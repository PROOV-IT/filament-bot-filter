<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Proovit\FilamentUrlWatcher\Models\UrlWatchSavedView;
use Proovit\UrlWatcher\Enums\UrlWatchClassification;
use Proovit\UrlWatcher\Enums\UrlWatchStatus;

final class UrlWatchDefaultViewPresets
{
    public static function key(string $target, string $preset): string
    {
        return sprintf('%s:%s', $target, $preset);
    }

    /**
     * @return array<string, array{name: string, description: string, state: array<string, mixed>, panels?: array<int, string>}>
     */
    public static function forTarget(string $target, ?string $panel = null): array
    {
        $presets = match ($target) {
            UrlWatchSavedView::TARGET_EVENTS => self::eventPresets(),
            default => self::watchPresets(),
        };

        $panel = filled($panel) ? strtolower(trim((string) $panel)) : null;

        if ($panel === null) {
            return $presets;
        }

        return array_filter($presets, static function (array $preset) use ($panel): bool {
            $panels = array_map(
                static fn (mixed $value): string => strtolower(trim((string) $value)),
                (array) ($preset['panels'] ?? []),
            );

            return $panels === [] || in_array($panel, $panels, true);
        });
    }

    /**
     * @return array<string, string>
     */
    public static function optionsForTarget(string $target, ?string $panel = null): array
    {
        return collect(self::forTarget($target, $panel))
            ->mapWithKeys(static fn (array $preset, string $key): array => [$key => $preset['name']])
            ->all();
    }

    /**
     * @return array{name: string, description: string, state: array<string, mixed>}|null
     */
    public static function find(string $target, string $key): ?array
    {
        return self::forTarget($target)[$key] ?? null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function databaseRows(): array
    {
        $rows = [];

        foreach ([UrlWatchSavedView::TARGET_WATCHES, UrlWatchSavedView::TARGET_EVENTS] as $target) {
            foreach (self::forTarget($target) as $presetKey => $preset) {
                $panels = array_values(array_filter(array_map(
                    static fn (mixed $value): string => trim((string) $value),
                    (array) ($preset['panels'] ?? []),
                )));

                $rows[] = [
                    'preset_key' => self::key($target, $presetKey),
                    'target' => $target,
                    'panel' => count($panels) === 1 ? $panels[0] : null,
                    'name' => $preset['name'],
                    'description' => $preset['description'],
                    'search' => $preset['state']['search'] ?? null,
                    'sort_column' => $preset['state']['sort_column'] ?? null,
                    'sort_direction' => $preset['state']['sort_direction'] ?? null,
                    'filters' => $preset['state']['filters'] ?? [],
                    'column_searches' => $preset['state']['column_searches'] ?? [],
                    'is_default' => false,
                    'is_system' => true,
                ];
            }
        }

        return $rows;
    }

    /**
     * @return array<string, array{name: string, description: string, state: array<string, mixed>}>
     */
    private static function watchPresets(): array
    {
        return [
            'pending_review' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.pending_review.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.pending_review.description'),
                'state' => [
                    'sort_column' => 'last_seen_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'status' => ['value' => UrlWatchStatus::Pending->value],
                    ],
                ],
            ],
            'confirmed_bots' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.confirmed_bots.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.confirmed_bots.description'),
                'state' => [
                    'sort_column' => 'count',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'classification' => ['value' => UrlWatchClassification::Bot->value],
                    ],
                ],
            ],
            'admin_panel_noise' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.admin_panel_noise.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.admin_panel_noise.description'),
                'panels' => ['admin'],
                'state' => [
                    'sort_column' => 'last_seen_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'panel' => ['value' => 'admin'],
                    ],
                ],
            ],
            'manager_panel_noise' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.manager_panel_noise.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.manager_panel_noise.description'),
                'panels' => ['manager'],
                'state' => [
                    'sort_column' => 'last_seen_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'panel' => ['value' => 'manager'],
                    ],
                ],
            ],
            'b2b_panel_noise' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.b2b_panel_noise.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.b2b_panel_noise.description'),
                'panels' => ['b2b'],
                'state' => [
                    'sort_column' => 'last_seen_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'panel' => ['value' => 'b2b'],
                    ],
                ],
            ],
            'reviewed' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.watches.reviewed.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.watches.reviewed.description'),
                'state' => [
                    'sort_column' => 'last_seen_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'status' => ['value' => UrlWatchStatus::Reviewed->value],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<string, array{name: string, description: string, state: array<string, mixed>}>
     */
    private static function eventPresets(): array
    {
        return [
            'recent_404s' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.events.recent_404s.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.events.recent_404s.description'),
                'state' => [
                    'sort_column' => 'occurred_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'status_code' => ['value' => '404'],
                    ],
                ],
            ],
            'write_attempts' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.events.write_attempts.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.events.write_attempts.description'),
                'state' => [
                    'sort_column' => 'occurred_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'method' => ['value' => 'POST'],
                    ],
                ],
            ],
            'confirmed_bot_timeline' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.events.confirmed_bot_timeline.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.events.confirmed_bot_timeline.description'),
                'state' => [
                    'sort_column' => 'occurred_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'classification' => ['value' => UrlWatchClassification::Bot->value],
                    ],
                ],
            ],
            'admin_recent_404s' => [
                'name' => __('filament-url-watcher::filament-url-watcher.presets.events.admin_recent_404s.name'),
                'description' => __('filament-url-watcher::filament-url-watcher.presets.events.admin_recent_404s.description'),
                'panels' => ['admin'],
                'state' => [
                    'sort_column' => 'occurred_at',
                    'sort_direction' => 'desc',
                    'filters' => [
                        'panel' => ['value' => 'admin'],
                        'status_code' => ['value' => '404'],
                    ],
                ],
            ],
        ];
    }
}
