<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('filament-bot-filter.saved_views.table', 'bot_probe_saved_views'), function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('panel')->nullable()->index();
            $table->boolean('is_default')->default(false)->index();
            $table->string('search')->nullable();
            $table->string('sort_column')->nullable();
            $table->string('sort_direction', 8)->nullable();
            $table->json('filters')->nullable();
            $table->json('column_searches')->nullable();
            $table->unsignedInteger('applied_count')->default(0);
            $table->timestamp('last_applied_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('filament-bot-filter.saved_views.table', 'bot_probe_saved_views'));
    }
};
