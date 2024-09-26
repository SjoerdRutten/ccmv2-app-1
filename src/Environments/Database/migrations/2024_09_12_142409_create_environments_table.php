<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->string('timezone');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('environments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->foreignId('timezone_id')
                ->nullable()
                ->references('id')
                ->on('timezones')
                ->nullOnDelete();
            $table->string('name', 40);
            $table->string('description', 80)->nullable();
            $table->integer('email_credits')->nullable();
            $table->boolean('notified');
            $table->timestamps();
        });
    }
};
