<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('why_choose_title')->nullable()->after('description');
            $table->text('why_choose_intro')->nullable()->after('why_choose_title');
            $table->string('why_choose_theme')->default('dark')->after('why_choose_intro');
            $table->json('why_choose_features')->nullable()->after('why_choose_theme');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['why_choose_title', 'why_choose_intro', 'why_choose_theme', 'why_choose_features']);
        });
    }
};
