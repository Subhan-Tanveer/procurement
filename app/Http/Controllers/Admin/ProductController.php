<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with(['category', 'service'])
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.products.create', compact('categories', 'services'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:product_categories,id',
            'service_id' => 'nullable|exists:services,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'featured_image' => 'nullable|image|max:5120',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,on_backorder',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('products', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        } else {
            unset($validated['featured_image']);
        }

        $product = Product::create($validated);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $product->load(['specifications', 'images', 'productPage']);

        return view('admin.products.edit', compact('product', 'categories', 'services'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:product_categories,id',
            'service_id' => 'nullable|exists:services,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'featured_image' => 'nullable|image|max:5120',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,on_backorder',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('products', 'public');
            $validated['featured_image'] = 'storage/' . $path;

            if ($product->featured_image && str_starts_with($product->featured_image, 'storage/')) {
                $oldPath = str_replace('storage/', '', $product->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
        } else {
            unset($validated['featured_image']);
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
