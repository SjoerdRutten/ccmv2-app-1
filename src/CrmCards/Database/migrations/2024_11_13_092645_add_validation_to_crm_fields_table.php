<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_fields', function (Blueprint $table) {
            $table->after('label_fr', function (Blueprint $table) {
                $table->json('pre_processing_rules')->nullable();
                $table->json('validation_rules')->nullable();
                $table->json('post_processing_rules')->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('crm_fields', function (Blueprint $table) {
            $table->dropColumn([
                'pre_process',
                'validate',
                'post_process',
            ]);
        });
    }
};
