<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('crm_field_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('crm_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('crm_field_type_id')->nullable()->constrained('crm_field_types')->nullOnDelete();
            $table->foreignId('crm_field_category_id')->nullable()->constrained('crm_field_categories')->nullOnDelete();
            $table->string('name');
            $table->string('label');
            $table->string('label_en')->nullable();
            $table->string('label_de')->nullable();
            $table->string('label_fr')->nullable();
            $table->boolean('is_shown_on_overview')->default(false);
            $table->boolean('is_shown_on_target_group_builder')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->integer('position')->default(0);
            $table->string('log_file')->nullable();
            $table->integer('overview_index')->default(0);
            $table->timestamps();
        });
    }
};
