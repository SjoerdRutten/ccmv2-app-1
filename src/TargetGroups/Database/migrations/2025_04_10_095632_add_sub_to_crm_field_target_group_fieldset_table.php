<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('target_group_fieldsets')->delete();

        Schema::table('crm_field_target_group_fieldset', function (Blueprint $table) {
            $table->string('field_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('crm_field_target_group_fieldset', function (Blueprint $table) {
            $table->dropColumn('field_name');
        });
    }
};
