<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('send_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments');
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('priority')->default(0);
            $table->string('name');
            $table->json('rules');
            $table->timestamps();
        });

        Schema::create('mail_server_send_rule', function (Blueprint $table) {
            $table->foreignId('send_rule_id')->constrained('send_rules');
            $table->foreignId('mail_server_id')->constrained('mail_servers');
            $table->unsignedInteger('priority')->default(100);
        });
    }
};
