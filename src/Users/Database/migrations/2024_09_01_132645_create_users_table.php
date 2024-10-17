<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('name');
            $table->smallInteger('gender')->default(0);
            $table->string('first_name', 80)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->string('last_name', 80)->nullable();
            $table->string('department', 80)->nullable();
            $table->string('function', 80)->nullable();
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
            $table->string('email');
            $table->string('telephone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('old_password', 80)->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('screen_resolution', 20)->nullable();
            $table->integer('rows')->default(50);
            $table->timestamp('first_login')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_system')->default(false);
            $table->json('allowed_ips')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }
};
