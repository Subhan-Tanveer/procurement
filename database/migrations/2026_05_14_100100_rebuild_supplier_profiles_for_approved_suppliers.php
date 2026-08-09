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
            DB::statement('DROP TABLE IF EXISTS supplier_profiles_new;');
            DB::statement('DROP INDEX IF EXISTS supplier_profiles_new_slug_unique;');

            Schema::create('supplier_profiles_new', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
                $table->string('organization_name');
                $table->string('slug')->unique();
                $table->string('contact_name')->nullable();
                $table->string('contact_email')->nullable();
                $table->string('contact_phone', 30)->nullable();
                $table->string('category')->nullable();
                $table->text('business_address')->nullable();
                $table->string('business_phone', 30)->nullable();
                $table->string('website')->nullable();
                $table->text('description')->nullable();
                $table->string('logo')->nullable();
                $table->string('status')->default('approved');
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->text('review_notes')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO supplier_profiles_new (
                    id, user_id, organization_name, slug, contact_name, contact_email, contact_phone,
                    category, business_address, business_phone, website, description, logo,
                    status, reviewed_by, reviewed_at, review_notes, created_at, updated_at
                )
                SELECT
                    supplier_profiles.id,
                    supplier_profiles.user_id,
                    supplier_profiles.organization_name,
                    supplier_profiles.slug,
                    users.name,
                    users.email,
                    users.phone_number,
                    supplier_profiles.category,
                    supplier_profiles.business_address,
                    supplier_profiles.business_phone,
                    supplier_profiles.website,
                    supplier_profiles.description,
                    supplier_profiles.logo,
                    supplier_profiles.status,
                    supplier_profiles.reviewed_by,
                    supplier_profiles.reviewed_at,
                    supplier_profiles.review_notes,
                    supplier_profiles.created_at,
                    supplier_profiles.updated_at
                FROM supplier_profiles
                LEFT JOIN users ON users.id = supplier_profiles.user_id");

            Schema::drop('supplier_profiles');
            Schema::rename('supplier_profiles_new', 'supplier_profiles');
            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        Schema::table('supplier_profiles', function (Blueprint $table) {
            // user_id is already unique from the table's original creation — only the
            // nullability needs to change here. Redeclaring ->unique() alongside ->change()
            // makes Laravel re-issue an ADD CONSTRAINT on Postgres, which fails because the
            // constraint already exists.
            $table->foreignId('user_id')->nullable()->change();
            $table->string('contact_name')->nullable()->after('slug');
            $table->string('contact_email')->nullable()->after('contact_name');
            $table->string('contact_phone', 30)->nullable()->after('contact_email');
        });

        // Laravel's query-builder leftJoin()->update() only produces valid SQL on MySQL —
        // Postgres doesn't support joined UPDATEs the same way and needs UPDATE ... FROM.
        if ($driver === 'pgsql') {
            DB::statement('
                UPDATE supplier_profiles
                SET contact_name = COALESCE(supplier_profiles.contact_name, users.name),
                    contact_email = COALESCE(supplier_profiles.contact_email, users.email),
                    contact_phone = COALESCE(supplier_profiles.contact_phone, users.phone_number)
                FROM users
                WHERE users.id = supplier_profiles.user_id
            ');
        } else {
            DB::table('supplier_profiles')
                ->leftJoin('users', 'users.id', '=', 'supplier_profiles.user_id')
                ->update([
                    'supplier_profiles.contact_name' => DB::raw('COALESCE(supplier_profiles.contact_name, users.name)'),
                    'supplier_profiles.contact_email' => DB::raw('COALESCE(supplier_profiles.contact_email, users.email)'),
                    'supplier_profiles.contact_phone' => DB::raw('COALESCE(supplier_profiles.contact_phone, users.phone_number)'),
                ]);
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');
            DB::statement('DROP TABLE IF EXISTS supplier_profiles_old;');
            DB::statement('DROP INDEX IF EXISTS supplier_profiles_old_slug_unique;');

            Schema::create('supplier_profiles_old', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('organization_name');
                $table->string('slug')->unique();
                $table->string('category')->nullable();
                $table->text('business_address')->nullable();
                $table->string('business_phone', 30)->nullable();
                $table->string('website')->nullable();
                $table->text('description')->nullable();
                $table->string('logo')->nullable();
                $table->string('status')->default('pending_review');
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->text('review_notes')->nullable();
                $table->timestamps();
            });

            DB::statement("INSERT INTO supplier_profiles_old (
                    id, user_id, organization_name, slug, category, business_address, business_phone,
                    website, description, logo, status, reviewed_by, reviewed_at, review_notes,
                    created_at, updated_at
                )
                SELECT
                    id, user_id, organization_name, slug, category, business_address, business_phone,
                    website, description, logo, status, reviewed_by, reviewed_at, review_notes,
                    created_at, updated_at
                FROM supplier_profiles
                WHERE user_id IS NOT NULL");

            Schema::drop('supplier_profiles');
            Schema::rename('supplier_profiles_old', 'supplier_profiles');
            DB::statement('PRAGMA foreign_keys=ON;');
            return;
        }

        Schema::table('supplier_profiles', function (Blueprint $table) {
            $table->dropColumn(['contact_name', 'contact_email', 'contact_phone']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
