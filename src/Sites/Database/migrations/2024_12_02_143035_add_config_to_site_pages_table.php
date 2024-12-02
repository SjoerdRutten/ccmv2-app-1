<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('site_page_blocks');
        Schema::table('site_pages', function (Blueprint $table) {
            $table->json('config')->nullable()->after('end_at');
        });
    }
};
