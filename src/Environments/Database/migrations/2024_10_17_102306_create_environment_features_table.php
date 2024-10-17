<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('environment_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments');
            $table->string('feature');
            $table->timestamps();
        });
    }
};
