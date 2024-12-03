<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_scrapers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_layout_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('site_block_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('target', ['layout', 'block'])->default('layout');
            $table->string('url');
            $table->string('base_url');
            $table->string('start_selector')->nullable();
            $table->string('end_selector')->nullable();
            $table->dateTime('last_scraped_at')->nullable();
            $table->string('status')->nullable();
            $table->longText('original_html')->nullable();
            $table->longText('converted_html')->nullable();
            $table->timestamps();
        });
    }
};
