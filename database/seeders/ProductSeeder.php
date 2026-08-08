<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSpecification;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drillingCategory = ProductCategory::where('slug', 'drilling-equipment')->first();
        $safetyCategory = ProductCategory::where('slug', 'safety-equipment')->first();
        $buildingCategory = ProductCategory::where('slug', 'building-materials')->first();
        $furnitureCategory = ProductCategory::where('slug', 'office-furniture')->first();

        $oilGasService = Service::where('slug', 'oil-gas-procurement')->first();
        $constructionService = Service::where('slug', 'construction-procurement')->first();
        $corporateService = Service::where('slug', 'corporate-procurement')->first();

        $products = [
            [
                'lookup' => ['slug' => 'professional-drilling-rig-equipment'],
                'data' => [
                    'category_id' => $drillingCategory?->id,
                    'service_id' => $oilGasService?->id,
                    'name' => 'Professional Drilling Rig Equipment',
                    'slug' => 'professional-drilling-rig-equipment',
                    'sku' => 'DRE-001',
                    'short_description' => 'High-performance drilling rig for oil and gas operations',
                    'description' => 'Complete drilling rig package with advanced control systems and safety features. Ideal for deep well operations.',
                    'price' => 5000000.00,
                    'currency' => 'NGN',
                    'featured_image' => 'site/assets/images/products/drilling-rig.jpg',
                    'is_featured' => true,
                    'is_active' => true,
                    'stock_status' => 'in_stock',
                    'sort_order' => 1,
                ],
                'specifications' => [
                    ['name' => 'Drilling Depth', 'value' => '5000', 'unit' => 'meters', 'sort_order' => 1],
                    ['name' => 'Power', 'value' => '2000', 'unit' => 'HP', 'sort_order' => 2],
                ],
            ],
            [
                'lookup' => ['slug' => 'industrial-safety-helmets'],
                'data' => [
                    'category_id' => $safetyCategory?->id,
                    'service_id' => $oilGasService?->id,
                    'name' => 'Industrial Safety Helmets',
                    'slug' => 'industrial-safety-helmets',
                    'sku' => 'SFT-001',
                    'short_description' => 'ANSI-certified safety helmets for industrial use',
                    'description' => 'High-impact resistant safety helmets with adjustable suspension system. Meets international safety standards.',
                    'price' => 15000.00,
                    'currency' => 'NGN',
                    'featured_image' => 'site/assets/images/products/safety-helmet.jpg',
                    'is_featured' => true,
                    'is_active' => true,
                    'stock_status' => 'in_stock',
                    'sort_order' => 2,
                ],
                'specifications' => [
                    ['name' => 'Material', 'value' => 'High-density polyethylene', 'unit' => null, 'sort_order' => 1],
                    ['name' => 'Certification', 'value' => 'ANSI Z89.1', 'unit' => null, 'sort_order' => 2],
                ],
            ],
            [
                'lookup' => ['slug' => 'portland-cement-50kg'],
                'data' => [
                    'category_id' => $buildingCategory?->id,
                    'service_id' => $constructionService?->id,
                    'name' => 'Portland Cement - 50kg Bags',
                    'slug' => 'portland-cement-50kg',
                    'sku' => 'BLD-001',
                    'short_description' => 'High-quality Portland cement for construction',
                    'description' => 'Premium grade Portland cement suitable for all types of construction work. Consistent quality and strength.',
                    'price' => 4500.00,
                    'currency' => 'NGN',
                    'featured_image' => 'site/assets/images/products/cement.jpg',
                    'is_featured' => false,
                    'is_active' => true,
                    'stock_status' => 'in_stock',
                    'sort_order' => 3,
                ],
                'specifications' => [
                    ['name' => 'Weight', 'value' => '50', 'unit' => 'kg', 'sort_order' => 1],
                    ['name' => 'Type', 'value' => 'Portland Cement Type I', 'unit' => null, 'sort_order' => 2],
                ],
            ],
            [
                'lookup' => ['slug' => 'executive-office-desk'],
                'data' => [
                    'category_id' => $furnitureCategory?->id,
                    'service_id' => $corporateService?->id,
                    'name' => 'Executive Office Desk',
                    'slug' => 'executive-office-desk',
                    'sku' => 'OFC-001',
                    'short_description' => 'Premium executive desk with storage',
                    'description' => 'Elegant executive desk crafted from high-quality wood with built-in storage compartments and cable management.',
                    'price' => 350000.00,
                    'currency' => 'NGN',
                    'featured_image' => 'site/assets/images/products/office-desk.jpg',
                    'is_featured' => true,
                    'is_active' => true,
                    'stock_status' => 'in_stock',
                    'sort_order' => 4,
                ],
                'specifications' => [
                    ['name' => 'Dimensions', 'value' => '180 x 90 x 75', 'unit' => 'cm (L x W x H)', 'sort_order' => 1],
                    ['name' => 'Material', 'value' => 'Solid Oak Wood', 'unit' => null, 'sort_order' => 2],
                ],
            ],
        ];

        foreach ($products as $productConfig) {
            $product = Product::updateOrCreate(
                $productConfig['lookup'],
                $productConfig['data']
            );

            foreach ($productConfig['specifications'] as $specification) {
                ProductSpecification::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'name' => $specification['name'],
                    ],
                    [
                        'value' => $specification['value'],
                        'unit' => $specification['unit'],
                        'sort_order' => $specification['sort_order'],
                    ]
                );
            }
        }
    }
}
