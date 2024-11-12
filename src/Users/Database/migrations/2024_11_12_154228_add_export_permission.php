<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('permissions')->insert([
            'group' => 'gds',
            'name' => 'export',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
