<?php

declare(strict_types=1);

namespace Proovit\FilamentUrlWatcher\Support\Filament;

use Proovit\FilamentUrlWatcher\Resources\UrlWatchEventResource;
use Proovit\FilamentUrlWatcher\Resources\UrlWatchResource;

final class UrlWatchWidgetUrls
{
    public static function watchesPreset(string $preset): string
    {
        return UrlWatchResource::getUrl('index', ['preset' => $preset]);
    }

    public static function eventsPreset(string $preset): string
    {
        return UrlWatchEventResource::getUrl('index', ['preset' => $preset]);
    }

    public static function eventsSearch(string $search): string
    {
        return UrlWatchEventResource::getUrl('index', ['search' => $search]);
    }

    public static function eventsOnDate(string $date): string
    {
        return UrlWatchEventResource::getUrl('index', ['occurred_on' => $date]);
    }
}
