<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('permissions')->insert([
            'group' => 'crm',
            'name' => 'import',
            'description' => 'CRM Kaarten importeren',
        ]);
    }
};
