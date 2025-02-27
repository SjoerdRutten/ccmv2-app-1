<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trackable_link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trackable_link_id')->constrained('trackable_links')->cascadeOnDelete();
            $table->foreignId('crm_card_id')->constrained('crm_cards')->cascadeOnDelete();
            $table->timestamps();

            $table->index('trackable_link_id');
            $table->index(['trackable_link_id', 'crm_card_id']);
        });
    }
};
