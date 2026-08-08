<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Drilling Equipment',
                'slug' => 'drilling-equipment',
                'description' => 'Professional drilling equipment and tools',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Safety Equipment',
                'slug' => 'safety-equipment',
                'description' => 'Industrial safety gear and protective equipment',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Building Materials',
                'slug' => 'building-materials',
                'description' => 'Construction materials and supplies',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Heavy Machinery',
                'slug' => 'heavy-machinery',
                'description' => 'Construction equipment and machinery',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Office Furniture',
                'slug' => 'office-furniture',
                'description' => 'Office desks, chairs, and furniture',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'IT Equipment',
                'slug' => 'it-equipment',
                'description' => 'Computers, printers, and IT hardware',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
