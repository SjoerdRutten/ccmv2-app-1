<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('environments', function (Blueprint $table) {
            $table->dropColumn([
                'email_credits',
                'notified',
            ]);
        });

        Schema::create('email_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained();
            $table->integer('quantity');
            $table->timestamps();
        });
    }
};
