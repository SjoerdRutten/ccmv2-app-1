<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('name');
        });

        DB::statement('UPDATE roles SET is_admin = 1 where name = \'admin\'');
    }
};
