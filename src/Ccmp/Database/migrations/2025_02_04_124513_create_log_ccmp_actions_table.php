<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_ccmp_actions', function (Blueprint $table) {
            $table->id();
            $table->biginteger('action_id')->unsigned();
            $table->string('crm_id');
            $table->tinyInteger('status');
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_ccmp_actions');
    }
};
