<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mailings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('ab_mailing_id')->nullable()->constrained('mailings')->nullOnDelete();
            $table->foreignId('email_id')->constrained('emails')->cascadeOnDelete();
            $table->foreignId('target_group_id')->constrained('target_groups')->cascadeOnDelete();
            $table->foreignId('email_category_id')->nullable()->constrained('email_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('sending_started_at')->nullable();
            $table->dateTime('sending_ready_at')->nullable();
            $table->integer('sending_speed')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('archive_status');
            $table->string('ab_test_group', 5)->nullable();
            $table->integer('mail_count')->default(0);
            $table->tinyInteger('send_confirmation')->default(1);
            $table->text('confirmation_email_addresses')->nullable();
            $table->boolean('has_confirmation_been_send')->default(false);
            $table->tinyInteger('send_reports')->default(3);
            $table->text('reports_email_addresses')->nullable();
            $table->boolean('is_reports_send')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('has_been_notified')->default(false);
            $table->boolean('has_been_executed_multiple_times')->default(false);
            $table->boolean('has_been_notified_bounce_rate');
            $table->timestamps();
        });
    }
};
