<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_card_imports', function (Blueprint $table) {
            $table->json('config')->after('file_name')->nullable();
        });
    }
};
