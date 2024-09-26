<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('order_type_id')->constrained('order_types')->cascadeOnDelete();
            $table->string('order_number', 80)->index();
            $table->string('store', 20)->index();
            $table->string('crm_id', 20)->index()->nullable();
            $table->datetime('order_time')->nullable()->index();
            $table->bigInteger('loyalty_card')->nullable()->index();
            $table->string('payment_method', 20)->nullable()->index();
            $table->integer('total_price')->nullable()->index();
            $table->integer('number_of_products')->nullable()->index();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }
};
