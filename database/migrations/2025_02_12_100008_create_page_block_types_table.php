<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_block_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('component_name');
            $table->enum('category', ['hero', 'content', 'card', 'testimonial', 'cta', 'gallery', 'faq', 'stats', 'map', 'form', 'other'])->default('other');
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->json('schema')->nullable(); // Field definitions for this block type
            $table->json('default_data')->nullable(); // Sample content
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_block_types');
    }
};
