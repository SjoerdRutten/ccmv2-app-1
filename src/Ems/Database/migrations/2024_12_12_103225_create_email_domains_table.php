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
            $table->string('dkim_selector_prefix')->nullable();
            $table->text('dkim_private_key')->nullable();
            $table->text('dkim_public_key')->nullable();
            $table->dateTime('dkim_expires_at')->nullable();
            $table->tinyInteger('dkim_status')->nullable();
            $table->string('dkim_status_message')->nullable();
            $table->timestamps();
        });
    }
};
