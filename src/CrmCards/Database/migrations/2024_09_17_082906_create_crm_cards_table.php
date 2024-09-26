<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_cards', function (Blueprint $table) {
            $table->id();
            $table->string('crm_id', 20)->unique();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_api_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('first_ip')->nullable();
            $table->string('latest_ip')->nullable();
            $table->string('first_ipv6')->nullable();
            $table->string('latest_ipv6')->nullable();
            $table->dateTime('first_email_send_at')->nullable()->index();
            $table->dateTime('latest_email_send_at')->nullable()->index();
            $table->dateTime('first_email_opened_at')->nullable()->index();
            $table->dateTime('latest_email_opened_at')->nullable()->index();
            $table->dateTime('first_email_clicked_at')->nullable()->index();
            $table->dateTime('latest_email_clicked_at')->nullable()->index();
            $table->dateTime('first_visit_at')->nullable()->index();
            $table->dateTime('latest_visit_at')->nullable()->index();
            $table->text('browser_ua')->nullable();
            $table->string('browser', 40)->nullable();
            $table->string('browser_device_type', 40)->nullable();
            $table->string('browser_device', 40)->nullable();
            $table->string('browser_os', 40)->nullable();
            $table->text('mailclient_ua')->nullable();
            $table->string('mailclient', 40)->nullable();
            $table->string('mailclient_device_type', 40)->nullable();
            $table->string('mailclient_device', 40)->nullable();
            $table->string('mailclient_os', 40)->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }
};
