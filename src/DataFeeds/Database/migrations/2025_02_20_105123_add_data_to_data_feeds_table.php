<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_feeds', function (Blueprint $table) {
            $table->longText('data')->nullable()->after('data_config');
        });
    }
};
