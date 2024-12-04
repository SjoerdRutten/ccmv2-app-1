<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_scrapers', function (Blueprint $table) {
            $table->string('block_name')->after('target')->nullable();
            $table->string('layout_name')->after('target')->nullable();
        });
    }
};
