<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('target_group_exports', function (Blueprint $table) {
            $table->foreignId('disk_id')->after('target_group_fieldset_id')->nullable()->constrained()->cascadeOnDelete();
            $table->dropColumn('disk');
        });
    }

    public function down(): void
    {
        Schema::table('target_group_exports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('disk_id');
            $table->string('disk')->after('file_type')->nullable();
        });
    }
};
