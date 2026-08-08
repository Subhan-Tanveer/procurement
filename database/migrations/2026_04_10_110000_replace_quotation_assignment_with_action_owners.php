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
            DB::statement('DROP TABLE IF EXISTS quotations_new;');
            DB::statement('DROP TABLE IF EXISTS quotations_old;');
            DB::statement('DROP INDEX IF EXISTS quotations_new_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS quotations_old_quote_number_unique;');

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
                $table->date('valid_until')->nullable();
                $table->timestamp('responded_at')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });

            DB::statement("INSERT INTO quotations_new (
                    id, quote_number, customer_name, customer_email, customer_phone, customer_company,
                    subject, message, status, total_amount, currency, notes, valid_until,
                    responded_at, paid_at, approved_by, rejected_by, paid_by, created_at, updated_at
                )
                SELECT
                    id, quote_number, customer_name, customer_email, customer_phone, customer_company,
                    subject, message, status, total_amount, currency, notes, valid_until,
                    responded_at, paid_at,
                    CASE WHEN status = 'accepted' THEN assigned_to ELSE NULL END,
                    CASE WHEN status = 'rejected' THEN assigned_to ELSE NULL END,
                    CASE WHEN paid_at IS NOT NULL THEN assigned_to ELSE NULL END,
                    created_at, updated_at
                FROM quotations");

            Schema::drop('quotations');
            Schema::rename('quotations_new', 'quotations');

            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete();
        });

        DB::statement("UPDATE quotations
            SET approved_by = assigned_to
            WHERE status = 'accepted' AND approved_by IS NULL AND assigned_to IS NOT NULL");

        DB::statement("UPDATE quotations
            SET rejected_by = assigned_to
            WHERE status = 'rejected' AND rejected_by IS NULL AND assigned_to IS NOT NULL");

        DB::statement("UPDATE quotations
            SET paid_by = assigned_to
            WHERE paid_at IS NOT NULL AND paid_by IS NULL AND assigned_to IS NOT NULL");

        Schema::table('quotations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_to');
        });
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');
            DB::statement('DROP TABLE IF EXISTS quotations_old;');
            DB::statement('DROP TABLE IF EXISTS quotations_new;');
            DB::statement('DROP INDEX IF EXISTS quotations_old_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS quotations_new_quote_number_unique;');

            Schema::create('quotations_old', function (Blueprint $table) {
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
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO quotations_old (
                    id, quote_number, customer_name, customer_email, customer_phone, customer_company,
                    subject, message, status, total_amount, currency, notes, assigned_to, valid_until,
                    responded_at, paid_at, created_at, updated_at
                )
                SELECT
                    id, quote_number, customer_name, customer_email, customer_phone, customer_company,
                    subject, message, status, total_amount, currency, notes,
                    COALESCE(approved_by, rejected_by, paid_by), valid_until,
                    responded_at, paid_at, created_at, updated_at
                FROM quotations");

            Schema::drop('quotations');
            Schema::rename('quotations_old', 'quotations');

            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
        });

        DB::statement("UPDATE quotations
            SET assigned_to = COALESCE(approved_by, rejected_by, paid_by)
            WHERE assigned_to IS NULL");

        Schema::table('quotations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropConstrainedForeignId('rejected_by');
            $table->dropConstrainedForeignId('paid_by');
        });
    }
};
