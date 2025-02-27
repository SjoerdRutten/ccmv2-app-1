<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trackable_links', function (Blueprint $table) {
            $table->id();
            $table->morphs('trackable');
            $table->string('link');
            $table->text('html')->nullable();
            $table->text('text')->nullable();
            $table->smallInteger('count')->default(1);
            $table->timestamps();

            $table->unique(['trackable_type', 'trackable_id', 'link']);
            $table->index('link');
        });
    }
};
