<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('helpdesk_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('visiting_address', 80)->nullable();
            $table->string('visiting_address_postcode', 20)->nullable();
            $table->string('visiting_address_city', 80)->nullable();
            $table->string('visiting_address_state', 80)->nullable();
            $table->string('visiting_address_country', 80)->nullable();
            $table->string('postal_address', 80)->nullable();
            $table->string('postal_address_postcode', 20)->nullable();
            $table->string('postal_address_city', 80)->nullable();
            $table->string('postal_address_state', 80)->nullable();
            $table->string('postal_address_country', 80)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('url', 80)->nullable();
            $table->string('logo')->nullable();
            $table->json('allowed_ips')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('id')->constrained('customers')->cascadeOnDelete();
        });
    }
};
