<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->string('domain');
            $table->string('description')->nullable();
            $table->string('return_path')->nullable();
            $table->timestamps();
        });

        Schema::create('email_dkims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_domain_id')->constrained()->cascadeOnDelete();
            $table->string('selector_prefix')->nullable();
            $table->text('private_key')->nullable();
            $table->text('public_key')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('status_message')->nullable();
            $table->dateTime('status_timestamp')->nullable();
            $table->timestamps();
        });
    }
};
