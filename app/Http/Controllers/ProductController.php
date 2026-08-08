<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPage;
use App\Models\ProductCategory;
use App\Models\Service;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'service', 'productPage'])
            ->where('is_active', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by service
        if ($request->filled('service')) {
            $query->where('service_id', $request->service);
        }

        // Search
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('short_description', 'like', $searchTerm);
            });
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            $query->where('stock_status', $request->stock_status);
        }

        // Sort
        $sortBy = $request->get('sort', 'sort_order');
        $sortDirection = $request->get('direction', 'asc');

        if ($sortBy === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortBy === 'price') {
            $query->orderBy('price', $sortDirection);
        } else {
            $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // Get categories and services for filters
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('site.products', compact('products', 'categories', 'services'));
    }

    /**
     * Display the specified product page.
     */
    public function show($slug)
    {
        // Try to find product page by slug (published pages)
        $page = ProductPage::with([
            'product' => function($query) {
                $query->with(['category', 'service', 'specifications', 'images']);
            },
            'blocks' => function($query) {
                $query->with('blockType')->where('is_active', true)->orderBy('sort_order');
            }
        ])
        ->where('slug', $slug)
        ->where('is_published', true)
        ->first();

        // If no published page, try finding product by slug directly
        if (!$page) {
            $product = Product::with(['category', 'service', 'specifications', 'images', 'productPage'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->first();

            if ($product && $product->productPage) {
                $page = $product->productPage->load(['blocks' => function($query) {
                    $query->with('blockType')->where('is_active', true)->orderBy('sort_order');
                }]);
            } elseif ($product) {
                $page = new ProductPage([
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                    'title' => $product->name,
                    'meta_title' => $product->meta_title,
                    'meta_description' => $product->meta_description,
                ]);
                $page->setRelation('blocks', collect());
            }

            if (!$product) {
                abort(404);
            }

            return view('site.product-page', compact('page', 'product'));
        }

        $product = $page->product;

        return view('site.product-page', compact('page', 'product'));
    }
}
