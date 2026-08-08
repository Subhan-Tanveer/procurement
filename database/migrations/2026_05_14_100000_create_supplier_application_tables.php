<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->unique();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone', 30)->nullable();
            $table->string('organization_name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_phone', 30)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('status')->default('submitted');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->foreignId('approved_supplier_profile_id')->nullable()->constrained('supplier_profiles')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('supplier_application_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('currency', 3)->default('NGN');
            $table->string('stock_status')->default('in_stock');
            $table->string('featured_image')->nullable();
            $table->string('status')->default('submitted');
            $table->text('review_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('converted_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_application_product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_application_product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('value');
            $table->string('unit')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('supplier_application_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_application_product_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_application_product_images');
        Schema::dropIfExists('supplier_application_product_specifications');
        Schema::dropIfExists('supplier_application_products');
        Schema::dropIfExists('supplier_applications');
    }
};
