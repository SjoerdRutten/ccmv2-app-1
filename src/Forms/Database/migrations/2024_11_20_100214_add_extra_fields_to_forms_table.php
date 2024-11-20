<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->after('fields', function (Blueprint $table) {
                $table->string('success_redirect')->nullable();
                $table->string('success_redirect_action')->nullable();
                $table->json('sync_actions')->nullable();
                $table->json('async_actions')->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn([
                'success_redirect',
                'success_redirect_action',
                'sync_actions',
                'async_actions',
            ]);
        });
    }
};
