<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trackable_pixel_opens', function (Blueprint $table) {
            $table->id();
            $table->morphs('trackable');
            $table->foreignId('crm_card_id')->constrained()->cascadeOnDelete();
            $table->boolean('online_version')->default(false);
            $table->timestamps();

            $table->index(['crm_card_id']);
        });
    }
};
