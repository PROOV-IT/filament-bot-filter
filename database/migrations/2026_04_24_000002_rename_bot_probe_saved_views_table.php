<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (Schema::hasTable('bot_probe_saved_views') && ! Schema::hasTable($tableName)) {
            Schema::rename('bot_probe_saved_views', $tableName);
        }
    }

    public function down(): void
    {
        $tableName = config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (Schema::hasTable($tableName) && ! Schema::hasTable('bot_probe_saved_views')) {
            Schema::rename($tableName, 'bot_probe_saved_views');
        }
    }
};
