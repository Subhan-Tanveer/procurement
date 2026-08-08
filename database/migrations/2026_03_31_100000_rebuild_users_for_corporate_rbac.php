<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');

            Schema::create('users_new', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('photo')->nullable();
                $table->string('phone_number', 20)->nullable();
                $table->string('role')->default('user');
                $table->string('job_title')->nullable();
                $table->string('department')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamp('last_login_at')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });

            DB::statement("
                INSERT INTO users_new (
                    id, name, email, photo, phone_number, role, job_title, department,
                    is_active, last_login_at, email_verified_at, password, remember_token,
                    created_at, updated_at
                )
                SELECT
                    id,
                    name,
                    email,
                    photo,
                    phone_number,
                    CASE
                        WHEN role = 'admin' THEN 'admin'
                        ELSE 'user'
                    END,
                    NULL,
                    NULL,
                    1,
                    NULL,
                    email_verified_at,
                    password,
                    remember_token,
                    created_at,
                    updated_at
                FROM users
            ");

            Schema::drop('users');
            Schema::rename('users_new', 'users');

            DB::statement('PRAGMA foreign_keys=ON;');

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('role');
            $table->string('department')->nullable()->after('job_title');
            $table->boolean('is_active')->default(true)->after('department');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });

        DB::table('users')
            ->whereIn('role', ['editor', 'customer'])
            ->update(['role' => 'user']);
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');

            Schema::create('users_old', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('photo')->nullable();
                $table->string('phone_number', 20)->nullable();
                $table->enum('role', ['admin', 'editor', 'customer'])->default('customer');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });

            DB::statement("
                INSERT INTO users_old (
                    id, name, email, photo, phone_number, role, email_verified_at,
                    password, remember_token, created_at, updated_at
                )
                SELECT
                    id,
                    name,
                    email,
                    photo,
                    phone_number,
                    CASE
                        WHEN role = 'admin' THEN 'admin'
                        ELSE 'customer'
                    END,
                    email_verified_at,
                    password,
                    remember_token,
                    created_at,
                    updated_at
                FROM users
            ");

            Schema::drop('users');
            Schema::rename('users_old', 'users');

            DB::statement('PRAGMA foreign_keys=ON;');

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'department', 'is_active', 'last_login_at']);
        });

        DB::table('users')
            ->where('role', 'user')
            ->update(['role' => 'customer']);
    }
};
