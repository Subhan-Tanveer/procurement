<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
