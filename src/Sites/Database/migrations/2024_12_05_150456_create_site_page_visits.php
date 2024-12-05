<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_page_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_page_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('crm_card_id')->index()->nullable()->constrained()->cascadeOnDelete();
            $table->string('crm_id')->nullable();
            $table->text('browser_ua');
            $table->string('browser', 40);
            $table->string('browser_device_type', 40);
            $table->string('browser_device', 40);
            $table->string('browser_os', 40);
            $table->ipAddress('ip');
            $table->string('uri');
            $table->string('referer')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index(['site_page_id', 'created_at']);
        });
    }
};
