<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_group_fieldsets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('crm_field_target_group_fieldsets', function (Blueprint $table) {
            $table->foreignId('target_group_id')->constrained('target_groups')->cascadeOnDelete();
            $table->foreignId('crm_field_id')->constrained('crm_fields')->cascadeOnDelete();
        });

        Schema::create('target_group_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_group_id')->constrained('target_groups')->cascadeOnDelete();
            $table->foreignId('target_group_fieldset_id')->constrained('target_group_fieldsets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_ready')->default(false);
            $table->json('config');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_group_exports');
        Schema::dropIfExists('crm_field_target_group_fieldsets');
        Schema::dropIfExists('target_group_fieldsets');
    }
};
