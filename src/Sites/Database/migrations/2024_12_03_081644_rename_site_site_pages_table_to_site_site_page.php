<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('site_site_pages', 'site_site_page');

        Schema::table('site_site_page', function (Blueprint $table) {
            $table->unique(['site_id', 'site_page_id'], 'unique_site_site_pages_page_id_page_id_idx');
        });
    }
};
