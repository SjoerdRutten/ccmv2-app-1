<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mail_servers', function (Blueprint $table) {
            $table->ipAddress('private_ip')->after('host');
        });
    }
};
