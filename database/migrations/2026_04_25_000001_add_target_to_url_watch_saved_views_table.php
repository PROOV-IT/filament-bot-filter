<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'target')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table): void {
            $table->string('target', 32)->default('watches')->after('description')->index();
        });
    }

    public function down(): void
    {
        $tableName = config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'target')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table): void {
            $table->dropColumn('target');
        });
    }
};
