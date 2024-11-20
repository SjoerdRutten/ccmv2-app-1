<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [];
        $permissions[] = ['group' => 'cms', 'name' => 'forms', 'description' => 'Formulieren', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['group' => 'cms', 'name' => 'actions', 'description' => 'Acties', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['group' => 'cms', 'name' => 'layouts', 'description' => 'Layouts', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['group' => 'cms', 'name' => 'sites', 'description' => 'Sites', 'created_at' => now(), 'updated_at' => now()];
        $permissions[] = ['group' => 'cms', 'name' => 'pages', 'description' => 'Paginas', 'created_at' => now(), 'updated_at' => now()];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }
};
