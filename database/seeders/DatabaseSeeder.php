<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AssignedRolePermissionSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            PageBlockTypeSeeder::class,
        ]);
    }
}
