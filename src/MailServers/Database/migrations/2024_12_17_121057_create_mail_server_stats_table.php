<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mail_servers', function (Blueprint $table) {
            $table->dropColumn([
                'queue_size',
                'deferred_queue_size',
                'load',
            ]);
        });

        Schema::create('mail_server_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_server_id')->constrained();
            $table->float('load', 2);
            $table->integer('memory_total');
            $table->integer('memory_used');
            $table->integer('memory_free');
            $table->integer('queue_size');
            $table->integer('deferred_queue_size');
            $table->timestamps();

            $table->index(['mail_server_id', 'created_at']);
        });
    }
};
