<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('app_downloader_stats')) {
            return;
        }

        Schema::create('app_downloader_stats', function (Blueprint $table): void {
            $table->id();
            $table->date('date');
            $table->string('platform', 20);
            $table->string('outcome', 10);
            $table->unsignedInteger('hits')->default(0);

            $table->unique(['date', 'platform', 'outcome'], 'app_downloader_stats_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_downloader_stats');
    }
};
