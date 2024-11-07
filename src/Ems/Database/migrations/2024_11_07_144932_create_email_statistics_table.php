<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crm_card_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('send')->default(0);
            $table->smallInteger('bounced')->default(0);
            $table->smallInteger('opened')->default(0);
            $table->smallInteger('clicked')->default(0);
            $table->timestamps();

            $table->unique(['email_id', 'crm_card_id'], 'email_statistics_crm_card_id');
        });
    }
};
