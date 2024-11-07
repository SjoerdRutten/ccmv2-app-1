<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('target_group_exports', function (Blueprint $table) {
            $table->string('error_message')->nullable()->after('status');
        });
    }
};
