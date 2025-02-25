<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_opt_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crm_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crm_field_id')->constrained()->cascadeOnDelete();
            $table->ipAddress('ip');
            $table->string('reason')->nullable();
            $table->text('explanation')->nullable();
            $table->timestamps();

            $table->index(['crm_card_id', 'crm_field_id']);
        });
    }
};
