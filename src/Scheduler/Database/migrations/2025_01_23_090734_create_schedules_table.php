<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('command');
            $table->json('arguments')->nullable();
            $table->json('options')->nullable();
            $table->json('pattern')->nullable();
            $table->json('run_on_days')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('on_one_server')->default(false);
            $table->boolean('without_overlapping')->default(false);
            $table->integer('ends_after_counter')->unsigned()->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_tasks');
    }
};
