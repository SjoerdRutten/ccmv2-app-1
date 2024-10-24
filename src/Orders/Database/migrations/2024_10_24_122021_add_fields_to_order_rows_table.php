<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_rows', function (Blueprint $table) {
            $table->string('order_row_id', 40)->nullable()->change();
            $table->integer('total_price')->after('price');
            $table->renameColumn('price', 'unit_price');
        });
    }
};
