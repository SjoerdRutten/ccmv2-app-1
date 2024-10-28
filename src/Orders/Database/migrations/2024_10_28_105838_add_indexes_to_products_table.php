<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['sku']);
        });

        Schema::table('order_rows', function (Blueprint $table) {
            $table->index(['order_id', 'product_id']);
        });
    }
};
