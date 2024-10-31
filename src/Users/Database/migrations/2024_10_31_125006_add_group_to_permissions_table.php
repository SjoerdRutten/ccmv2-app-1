<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group')->nullable()->after('id');
        });

        foreach (\DB::table('permissions')->get() as $permission) {
            $name = explode('.', $permission->name);

            DB::table('permissions')
                ->where('id', $permission->id)
                ->update([
                    'group' => $name[0],
                    'name' => Arr::get($name, 1) ?: 'overview',
                ]);
        }
    }
};
