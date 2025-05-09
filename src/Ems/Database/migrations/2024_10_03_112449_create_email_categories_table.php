<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('name_de')->nullable();
            $table->string('name_fr')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }
};
