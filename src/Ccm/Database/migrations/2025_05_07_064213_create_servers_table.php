<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->ipAddress('ip')->nullable();
            $table->string('status_url')->nullable();
            $table->json('config')->nullable();
            $table->timestamps();
        });

        Schema::create('server_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('cpu_count');
            $table->unsignedBigInteger('disk_total_space');
            $table->unsignedBigInteger('disk_free_space');
            $table->unsignedBigInteger('ram_total_space');
            $table->unsignedBigInteger('ram_free_space');
            $table->float('load', 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_status');
        Schema::dropIfExists('servers');
    }
};
