<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_dkim_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_dkim_id')->constrained()->cascadeOnDelete();
            $table->string('domain');
            $table->timestamps();

            $table->unique(['email_dkim_id', 'domain']);
        });
    }
};
