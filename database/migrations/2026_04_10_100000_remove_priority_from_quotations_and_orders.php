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
            DB::statement('DROP TABLE IF EXISTS orders_new;');
            DB::statement('DROP TABLE IF EXISTS quotations_old;');
            DB::statement('DROP TABLE IF EXISTS orders_old;');
            DB::statement('DROP INDEX IF EXISTS quotations_new_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS orders_new_order_number_unique;');
            DB::statement('DROP INDEX IF EXISTS quotations_old_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS orders_old_order_number_unique;');

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
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });

            DB::statement('INSERT INTO quotations_new (id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, total_amount, currency, notes, assigned_to, valid_until, responded_at, paid_at, created_at, updated_at)
                SELECT id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, total_amount, currency, notes, assigned_to, valid_until, responded_at, paid_at, created_at, updated_at
                FROM quotations');

            Schema::drop('quotations');
            Schema::rename('quotations_new', 'quotations');

            Schema::create('orders_new', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->foreignId('quotation_id')->nullable()->constrained('quotations')->nullOnDelete();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();
                $table->string('customer_company')->nullable();
                $table->string('status')->default('created');
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('currency', 10)->default('USD');
                $table->text('notes')->nullable();
                $table->text('delivery_address')->nullable();
                $table->string('delivery_contact')->nullable();
                $table->string('delivery_phone')->nullable();
                $table->date('expected_delivery_at')->nullable();
                $table->date('actual_delivery_at')->nullable();
                $table->string('tracking_ref')->nullable();
                $table->string('carrier')->nullable();
                $table->timestamps();
            });

            DB::statement('INSERT INTO orders_new (id, order_number, quotation_id, assigned_to, customer_name, customer_email, customer_phone, customer_company, status, total_amount, currency, notes, delivery_address, delivery_contact, delivery_phone, expected_delivery_at, actual_delivery_at, tracking_ref, carrier, created_at, updated_at)
                SELECT id, order_number, quotation_id, assigned_to, customer_name, customer_email, customer_phone, customer_company, status, total_amount, currency, notes, delivery_address, delivery_contact, delivery_phone, expected_delivery_at, actual_delivery_at, tracking_ref, carrier, created_at, updated_at
                FROM orders');

            Schema::drop('orders');
            Schema::rename('orders_new', 'orders');

            DB::statement('PRAGMA foreign_keys=ON;');

            return;
        }

        if (Schema::hasColumn('quotations', 'priority')) {
            Schema::table('quotations', function (Blueprint $table) {
                $table->dropColumn('priority');
            });
        }

        if (Schema::hasColumn('orders', 'priority')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('priority');
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');
            DB::statement('DROP TABLE IF EXISTS quotations_old;');
            DB::statement('DROP TABLE IF EXISTS orders_old;');
            DB::statement('DROP TABLE IF EXISTS quotations_new;');
            DB::statement('DROP TABLE IF EXISTS orders_new;');
            DB::statement('DROP INDEX IF EXISTS quotations_old_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS orders_old_order_number_unique;');
            DB::statement('DROP INDEX IF EXISTS quotations_new_quote_number_unique;');
            DB::statement('DROP INDEX IF EXISTS orders_new_order_number_unique;');

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
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
                $table->decimal('total_amount', 15, 2)->default(0);
                $table->string('currency', 3)->default('NGN');
                $table->text('notes')->nullable();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->date('valid_until')->nullable();
                $table->timestamp('responded_at')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO quotations_old (id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, priority, total_amount, currency, notes, assigned_to, valid_until, responded_at, paid_at, created_at, updated_at)
                SELECT id, quote_number, customer_name, customer_email, customer_phone, customer_company, subject, message, status, 'medium', total_amount, currency, notes, assigned_to, valid_until, responded_at, paid_at, created_at, updated_at
                FROM quotations");

            Schema::drop('quotations');
            Schema::rename('quotations_old', 'quotations');

            Schema::create('orders_old', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->foreignId('quotation_id')->nullable()->constrained('quotations')->nullOnDelete();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();
                $table->string('customer_company')->nullable();
                $table->string('status')->default('created');
                $table->string('priority')->nullable();
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('currency', 10)->default('USD');
                $table->text('notes')->nullable();
                $table->text('delivery_address')->nullable();
                $table->string('delivery_contact')->nullable();
                $table->string('delivery_phone')->nullable();
                $table->date('expected_delivery_at')->nullable();
                $table->date('actual_delivery_at')->nullable();
                $table->string('tracking_ref')->nullable();
                $table->string('carrier')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO orders_old (id, order_number, quotation_id, assigned_to, customer_name, customer_email, customer_phone, customer_company, status, priority, total_amount, currency, notes, delivery_address, delivery_contact, delivery_phone, expected_delivery_at, actual_delivery_at, tracking_ref, carrier, created_at, updated_at)
                SELECT id, order_number, quotation_id, assigned_to, customer_name, customer_email, customer_phone, customer_company, status, NULL, total_amount, currency, notes, delivery_address, delivery_contact, delivery_phone, expected_delivery_at, actual_delivery_at, tracking_ref, carrier, created_at, updated_at
                FROM orders");

            Schema::drop('orders');
            Schema::rename('orders_old', 'orders');

            DB::statement('PRAGMA foreign_keys=ON;');

            return;
        }

        Schema::table('quotations', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('priority')->nullable()->after('status');
        });
    }
};
