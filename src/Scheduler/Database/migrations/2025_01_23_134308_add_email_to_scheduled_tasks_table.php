<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_tasks', function (Blueprint $table) {
            $table->after('without_overlapping', function (Blueprint $table) {
                $table->string('email_success')->nullable();
                $table->string('email_failure')->nullable();
            });
        });

        Schema::create('scheduled_task_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduled_task_id')->constrained();
            $table->boolean('is_success');
            $table->longText('output')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }
};
