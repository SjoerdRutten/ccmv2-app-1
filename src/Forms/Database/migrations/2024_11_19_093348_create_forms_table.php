<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('uuid', 36)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('fields')->nullable();
            $table->longText('html_form')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->foreignId('crm_card_id')->nullable()->constrained('crm_cards')->cascadeOnDelete();
            $table->ipAddress('ip_address');
            $table->json('headers');
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_responses');
        Schema::dropIfExists('forms');
    }
};
