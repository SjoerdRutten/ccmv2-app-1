<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_card_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_card_id')->constrained('crm_cards')->cascadeOnDelete();
            $table->json('changes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_card_logs');
    }
};
