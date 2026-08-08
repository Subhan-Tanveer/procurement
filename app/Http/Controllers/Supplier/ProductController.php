<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function profile()
    {
        return Auth::user()->supplierProfile;
    }

    public function index()
    {
        $profile = $this->profile();
        $products = Product::where('supplier_id', $profile->id)
            ->with(['category', 'images'])
            ->latest()
            ->paginate(20);

        return view('supplier.products.index', compact('products', 'profile'));
    }

    public function create()
    {
        $profile = $this->profile();
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('supplier.products.create', compact('profile', 'categories'));
    }

    public function store(Request $request)
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['nullable', 'exists:product_categories,id'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'price'             => ['nullable', 'numeric', 'min:0'],
            'currency'          => ['nullable', 'string', 'max:3'],
            'stock_status'      => ['nullable', 'in:in_stock,out_of_stock,on_backorder'],
            'featured_image'    => ['nullable', 'image', 'max:5120'],
            'specs'             => ['nullable', 'array'],
            'specs.*.label'     => ['required_with:specs', 'string', 'max:255'],
            'specs.*.value'     => ['required_with:specs', 'string', 'max:255'],
            'images'            => ['nullable', 'array', 'max:10'],
            'images.*'          => ['image', 'max:5120'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        try {
            $slug = Str::slug($validated['name']) . '-' . Str::random(6);

            $featuredImagePath = null;
            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('products/supplier', 'public');
                $featuredImagePath = 'storage/' . $path;

                MediaFile::create([
                    'uploader_id' => Auth::id(),
                    'supplier_id' => $profile->id,
                    'file_name'   => $request->file('featured_image')->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_size'   => $request->file('featured_image')->getSize(),
                    'mime_type'   => $request->file('featured_image')->getMimeType(),
                ]);
            }

            $product = Product::create([
                'supplier_id'       => $profile->id,
                'category_id'       => $validated['category_id'] ?? null,
                'name'              => $validated['name'],
                'slug'              => $slug,
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'price'             => $validated['price'] ?? null,
                'currency'          => $validated['currency'] ?? 'NGN',
                'featured_image'    => $featuredImagePath,
                'stock_status'      => $validated['stock_status'] ?? 'in_stock',
                'is_active'         => false,
                'approval_status'   => 'pending',
                'meta_title'        => $validated['meta_title'] ?? null,
                'meta_description'  => $validated['meta_description'] ?? null,
            ]);

            // Specs
            if (!empty($validated['specs'])) {
                foreach ($validated['specs'] as $i => $spec) {
                    $product->specifications()->create([
                        'label'      => $spec['label'],
                        'value'      => $spec['value'],
                        'sort_order' => $i,
                    ]);
                }
            }

            // Additional images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $i => $imgFile) {
                    $imgPath = $imgFile->store('products/supplier', 'public');

                    $media = MediaFile::create([
                        'uploader_id' => Auth::id(),
                        'supplier_id' => $profile->id,
                        'file_name'   => $imgFile->getClientOriginalName(),
                        'file_path'   => $imgPath,
                        'file_size'   => $imgFile->getSize(),
                        'mime_type'   => $imgFile->getMimeType(),
                    ]);

                    ProductImage::create([
                        'product_id'    => $product->id,
                        'media_file_id' => $media->id,
                        'image_path'    => 'storage/' . $imgPath,
                        'is_primary'    => $i === 0 && !$featuredImagePath,
                        'sort_order'    => $i,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('supplier.products.show', $product->id)
                ->with('success', 'Product submitted for approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Supplier product store failed: ' . $e->getMessage());

            return redirect()->back()->withInput()
                ->with('error', 'Failed to submit product. Please try again.');
        }
    }

    public function show(int $id)
    {
        $profile = $this->profile();
        $product = Product::where('supplier_id', $profile->id)
            ->with(['specifications', 'images', 'category'])
            ->findOrFail($id);

        return view('supplier.products.show', compact('product', 'profile'));
    }

    public function edit(int $id)
    {
        $profile = $this->profile();
        $product = Product::where('supplier_id', $profile->id)->findOrFail($id);

        if ($product->approval_status === 'approved') {
            return redirect()->route('supplier.products.show', $id)
                ->with('error', 'Approved products cannot be edited. Contact support to request changes.');
        }

        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $product->load(['specifications', 'images']);

        return view('supplier.products.edit', compact('product', 'profile', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $profile = $this->profile();
        $product = Product::where('supplier_id', $profile->id)->findOrFail($id);

        if ($product->approval_status === 'approved') {
            return redirect()->route('supplier.products.show', $id)
                ->with('error', 'Approved products cannot be edited.');
        }

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['nullable', 'exists:product_categories,id'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'price'             => ['nullable', 'numeric', 'min:0'],
            'currency'          => ['nullable', 'string', 'max:3'],
            'stock_status'      => ['nullable', 'in:in_stock,out_of_stock,on_backorder'],
            'featured_image'    => ['nullable', 'image', 'max:5120'],
            'specs'             => ['nullable', 'array'],
            'specs.*.label'     => ['required_with:specs', 'string', 'max:255'],
            'specs.*.value'     => ['required_with:specs', 'string', 'max:255'],
            'images'            => ['nullable', 'array', 'max:10'],
            'images.*'          => ['image', 'max:5120'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'category_id'       => $validated['category_id'] ?? null,
                'name'              => $validated['name'],
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'price'             => $validated['price'] ?? null,
                'currency'          => $validated['currency'] ?? 'NGN',
                'stock_status'      => $validated['stock_status'] ?? 'in_stock',
                'approval_status'   => 'pending',
                'approval_notes'    => null,
                'meta_title'        => $validated['meta_title'] ?? null,
                'meta_description'  => $validated['meta_description'] ?? null,
            ];

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('products/supplier', 'public');
                $data['featured_image'] = 'storage/' . $path;

                MediaFile::create([
                    'uploader_id' => Auth::id(),
                    'supplier_id' => $profile->id,
                    'file_name'   => $request->file('featured_image')->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_size'   => $request->file('featured_image')->getSize(),
                    'mime_type'   => $request->file('featured_image')->getMimeType(),
                ]);
            }

            $product->update($data);

            // Replace specs
            $product->specifications()->delete();
            if (!empty($validated['specs'])) {
                foreach ($validated['specs'] as $i => $spec) {
                    $product->specifications()->create([
                        'label'      => $spec['label'],
                        'value'      => $spec['value'],
                        'sort_order' => $i,
                    ]);
                }
            }

            // Append new images
            if ($request->hasFile('images')) {
                $currentCount = $product->images()->count();
                foreach ($request->file('images') as $i => $imgFile) {
                    $imgPath = $imgFile->store('products/supplier', 'public');

                    $media = MediaFile::create([
                        'uploader_id' => Auth::id(),
                        'supplier_id' => $profile->id,
                        'file_name'   => $imgFile->getClientOriginalName(),
                        'file_path'   => $imgPath,
                        'file_size'   => $imgFile->getSize(),
                        'mime_type'   => $imgFile->getMimeType(),
                    ]);

                    ProductImage::create([
                        'product_id'    => $product->id,
                        'media_file_id' => $media->id,
                        'image_path'    => 'storage/' . $imgPath,
                        'is_primary'    => false,
                        'sort_order'    => $currentCount + $i,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('supplier.products.show', $product->id)
                ->with('success', 'Product updated and re-submitted for approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Supplier product update failed: ' . $e->getMessage());

            return redirect()->back()->withInput()
                ->with('error', 'Failed to update product. Please try again.');
        }
    }
}
