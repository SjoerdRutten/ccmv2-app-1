<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_card_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('file_name');
            $table->json('fields');
            $table->integer('number_of_rows')->nullable();
            $table->integer('quantity_updated_rows')->nullable();
            $table->json('updated_rows')->nullable();
            $table->integer('quantity_created_rows')->nullable();
            $table->json('created_rows')->nullable();
            $table->integer('quantity_empty_rows')->nullable();
            $table->json('empty_rows')->nullable();
            $table->integer('quantity_error_rows')->nullable();
            $table->json('error_rows')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }
};
