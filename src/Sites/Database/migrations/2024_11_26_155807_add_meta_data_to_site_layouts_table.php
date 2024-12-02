<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_layouts', function (Blueprint $table) {
            $table->after('description', function (Blueprint $table) {
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->boolean('follow')->default(0);
                $table->boolean('index')->default(0);

            });
        });
    }
};
