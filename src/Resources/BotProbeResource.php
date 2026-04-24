<?php

declare(strict_types=1);

namespace Proovit\FilamentBotFilter\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\BotFilter\Models\BotProbe;
use Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages\EditBotProbe;
use Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages\ManageBotProbes;
use Proovit\FilamentBotFilter\Resources\BotProbeResource\Pages\ViewBotProbe;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeFormSchema;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeInfolistSchema;
use Proovit\FilamentBotFilter\Support\Filament\BotProbeTable;

final class BotProbeResource extends Resource
{
    protected static ?string $model = BotProbe::class;

    protected static ?string $slug = 'security/bot-probes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?int $navigationSort = 99;

    public static function getModelLabel(): string
    {
        return __('filament-bot-filter::filament-bot-filter.resources.bot_probe.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-bot-filter::filament-bot-filter.resources.bot_probe.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return BotProbeFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BotProbeInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return BotProbeTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-bot-filter::filament-bot-filter.resources.bot_probe.navigation_group');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-bot-filter.show_navigation', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBotProbes::route('/'),
            'view' => ViewBotProbe::route('/{record}'),
            'edit' => EditBotProbe::route('/{record}/edit'),
        ];
    }
}
