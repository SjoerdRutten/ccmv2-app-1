<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_mailings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments');
            $table->foreignId('email_id')->constrained('emails');
            $table->foreignId('target_group_id')->constrained('target_groups');
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::table('email_queues', function (Blueprint $table) {
            $table->foreignId('email_mailing_id')->nullable()->after('crm_card_id')->constrained()->cascadeOnDelete();
        });
    }
};
