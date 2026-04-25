<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = (string) config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (! Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
            if (! Schema::hasColumn($tableName, 'preset_key')) {
                $table->string('preset_key')->nullable()->after('description')->index();
            }

            if (! Schema::hasColumn($tableName, 'is_system')) {
                $table->boolean('is_system')->default(false)->after('is_default');
            }
        });
    }

    public function down(): void
    {
        $tableName = (string) config('filament-url-watcher.saved_views.table', 'url_watch_saved_views');

        if (! Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
            if (Schema::hasColumn($tableName, 'preset_key')) {
                $table->dropColumn('preset_key');
            }

            if (Schema::hasColumn($tableName, 'is_system')) {
                $table->dropColumn('is_system');
            }
        });
    }
};
