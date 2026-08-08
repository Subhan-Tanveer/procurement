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

            Schema::create('quotations_new', function (Blueprint $table) {
                $table->id();
                $table->string('quote_number')->unique();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone', 20)->nullable();
                $table->string('customer_company')->nullable();
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->enum('status', ['new', 'pending', 'reviewed', 'quoted', 'accepted', 'rejected', 'expired'])->default('pending');
                $table->decimal('total_amount', 15, 2)->default(0);
                $table->string('currency', 3)->default('NGN');
                $table->text('notes')->nullable();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->date('valid_until')->nullable();
                $table->timestamp('responded_at')->nullable();
                $table->timestamps();
            });

            DB::statement('INSERT INTO quotations_new (id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, total_amount, currency, notes, assigned_to, valid_until, responded_at, created_at, updated_at)
                SELECT id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, total_amount, currency, notes, assigned_to, valid_until, responded_at, created_at, updated_at
                FROM quotations');

            Schema::drop('quotations');
            Schema::rename('quotations_new', 'quotations');

            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE quotations MODIFY status ENUM('new','pending','reviewed','quoted','accepted','rejected','expired') DEFAULT 'pending'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE quotations DROP CONSTRAINT IF EXISTS quotations_status_check");
            DB::statement("ALTER TABLE quotations ADD CONSTRAINT quotations_status_check CHECK (status IN ('new','pending','reviewed','quoted','accepted','rejected','expired'))");
            return;
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');

            Schema::create('quotations_old', function (Blueprint $table) {
                $table->id();
                $table->string('quote_number')->unique();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone', 20)->nullable();
                $table->string('customer_company')->nullable();
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->enum('status', ['pending', 'reviewed', 'quoted', 'accepted', 'rejected', 'expired'])->default('pending');
                $table->decimal('total_amount', 15, 2)->default(0);
                $table->string('currency', 3)->default('NGN');
                $table->text('notes')->nullable();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->date('valid_until')->nullable();
                $table->timestamp('responded_at')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO quotations_old (id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, total_amount, currency, notes, assigned_to, valid_until, responded_at, created_at, updated_at)
                SELECT id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message,
                       CASE WHEN status = 'new' THEN 'pending' ELSE status END,
                       total_amount, currency, notes, assigned_to, valid_until, responded_at, created_at, updated_at
                FROM quotations");

            Schema::drop('quotations');
            Schema::rename('quotations_old', 'quotations');

            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE quotations MODIFY status ENUM('pending','reviewed','quoted','accepted','rejected','expired') DEFAULT 'pending'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE quotations DROP CONSTRAINT IF EXISTS quotations_status_check");
            DB::statement("ALTER TABLE quotations ADD CONSTRAINT quotations_status_check CHECK (status IN ('pending','reviewed','quoted','accepted','rejected','expired'))");
            return;
        }
    }
};
