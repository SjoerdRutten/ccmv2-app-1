<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_eans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->bigInteger('ean');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('ean');
        });
    }
};
