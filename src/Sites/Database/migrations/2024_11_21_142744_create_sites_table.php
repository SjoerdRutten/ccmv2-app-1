<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('domain');
            $table->string('description')->nullable();
            $table->string('favicon_disk')->nullable();
            $table->string('favicon')->nullable();
            $table->timestamps();
        });

        Schema::create('site_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_category_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['js', 'css']); // js of css
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->longText('body')->nullable();
            $table->longText('minimized_body')->nullable();
            $table->timestamps();
        });

        Schema::create('site_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->longText('body')->nullable();
            $table->timestamps();
        });

        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('site_layout_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
        });

        Schema::create('site_site_pages', function (Blueprint $table) {
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_page_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('site_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->longText('body')->nullable();
            $table->timestamps();
        });

        Schema::create('site_page_blocks', function (Blueprint $table) {
            $table->foreignId('site_page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_block_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('position')->default(0);
        });

        Schema::create('site_page_imports', function (Blueprint $table) {
            $table->foreignId('site_page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_import_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('position')->default(0);
        });

        Schema::create('site_block_imports', function (Blueprint $table) {
            $table->foreignId('site_block_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_import_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('position')->default(0);
        });

        Schema::create('site_layout_imports', function (Blueprint $table) {
            $table->foreignId('site_layout_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_import_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('position')->default(0);
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->foreignId('site_page_id')->after('environment_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_page_id');
        });
        Schema::dropIfExists('site_site_pages');
        Schema::dropIfExists('site_layout_imports');
        Schema::dropIfExists('site_page_imports');
        Schema::dropIfExists('site_block_imports');
        Schema::dropIfExists('site_page_blocks');
        Schema::dropIfExists('site_blocks');
        Schema::dropIfExists('site_pages');
        Schema::dropIfExists('site_layouts');
        Schema::dropIfExists('site_imports');
        Schema::dropIfExists('sites');
        Schema::dropIfExists('site_categories');
    }
};
