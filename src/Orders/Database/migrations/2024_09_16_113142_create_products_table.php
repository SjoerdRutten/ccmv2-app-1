<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->string('sku')->nullable();
            $table->string('ean')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }
};
