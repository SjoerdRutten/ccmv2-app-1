<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_blocks', function (Blueprint $table) {
            $table->foreignId('form_id')->after('site_category_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
