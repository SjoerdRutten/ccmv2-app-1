<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->morphs('model');
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        });

        $permissions = [];
        $permissions[] = ['name' => 'crm', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['name' => 'ems', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['name' => 'gds', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['name' => 'gds.transactions', 'created_at' => now(), 'updated_at' => now()];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }
};
