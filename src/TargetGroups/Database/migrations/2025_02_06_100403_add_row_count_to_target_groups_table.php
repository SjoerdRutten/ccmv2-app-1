<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('target_groups', function (Blueprint $table) {
            $table->after('filters', function (Blueprint $table) {
                $table->integer('row_count')->nullable();
                $table->dateTime('row_count_updated_at')->nullable();
            });
        });
    }
};
