<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('email_category_id')->nullable()->constrained('email_categories')->nullOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('remarks')->nullable();
            $table->datetime('start_at')->nullable();
            $table->datetime('end_at')->nullable();
            $table->longText('content')->nullable();
            $table->string('content_type')->nullable();
            $table->longText('unpublished_content')->nullable();
            $table->string('unpublished_content_type')->nullable();
            $table->timestamps();
        });
    }
};
