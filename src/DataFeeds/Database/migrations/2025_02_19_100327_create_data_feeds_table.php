<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_public')->default(false);
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type', 50);
            $table->json('feed_config')->nullable();
            $table->json('data_config')->nullable();
            $table->timestamps();
        });

        Schema::create('data_feed_fetches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_feed_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->string('disk')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_feed_fetches');
        Schema::dropIfExists('data_feeds');
    }
};
