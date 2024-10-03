<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('email_category_id')->nullable()->constrained('email_categories')->nullOnDelete();
            $table->string('name');
            $table->string('description', 80)->nullable();
            $table->string('sender_email', 80);
            $table->string('sender_name', 80)->nullable();
            $table->string('recipient');
            $table->string('reply_to')->nullable();
            $table->string('subject');
            $table->string('optout_url')->nullable();
            $table->string('stripo_html')->nullable();
            $table->string('stripo_css')->nullable();
            $table->longText('html')->nullable();
            $table->string('html_type', 80);
            $table->longText('text')->nullable();
            $table->string('utm_code')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_template')->default(false);
            $table->timestamps();
        });
    }
};
