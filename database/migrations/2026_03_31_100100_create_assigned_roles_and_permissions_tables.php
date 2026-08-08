<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assigned_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create('assigned_role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_role_id')->constrained('assigned_roles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['assigned_role_id', 'user_id']);
        });

        Schema::create('assigned_role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_role_id')->constrained('assigned_roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['assigned_role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assigned_role_permission');
        Schema::dropIfExists('assigned_role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('assigned_roles');
    }
};
