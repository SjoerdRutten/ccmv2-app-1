<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable();
            $table->string('order_row_id', 40)->index();
            $table->boolean('is_promo')->default(false);
            $table->double('amount');
            $table->string('unit')->nullable();
            $table->integer('price');
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });
    }
};
