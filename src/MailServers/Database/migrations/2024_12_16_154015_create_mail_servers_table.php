<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_servers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained();
            $table->string('host');
            $table->string('description')->nullable();
            $table->string('port');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('encryption')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_valid')->default(false);
            $table->string('status')->nullable();
            $table->integer('queue_size')->default(0);
            $table->integer('deferred_queue_size')->default(0);
            $table->integer('load')->default(0);
            $table->timestamps();
        });
    }
};
