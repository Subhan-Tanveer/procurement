<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPage;
use App\Models\PageBlockType;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductPageController extends Controller
{
    /**
     * List all product pages (including standalone pages).
     */
    public function index()
    {
        $pages = ProductPage::with('product')
            ->orderByDesc('updated_at')
            ->paginate(20);

        $products = Product::orderBy('name')->get();

        return view('admin.products.page-index', compact('pages', 'products'));
    }

    /**
     * Create a new page (standalone or linked to a product).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
        ]);

        $productId = $request->input('product_id');
        $product = $productId ? Product::find($productId) : null;

        if ($productId) {
            $existing = ProductPage::where('product_id', $productId)->first();
            if ($existing) {
                return redirect()
                    ->route('admin.product-pages.edit', $existing)
                    ->with('success', 'Page already exists for that product. Opening it now.');
            }
        }

        $title = $request->input('title')
            ?: ($product ? $product->name : 'Standalone Page');

        $slugBase = $request->input('slug')
            ?: ($product ? $product->slug : Str::slug($title));

        $slug = $this->uniqueSlug($slugBase);

        $page = ProductPage::create([
            'product_id' => $product?->id,
            'slug' => $slug,
            'title' => $title,
            'is_published' => false,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.product-pages.edit', $page)
            ->with('success', 'Page created. You can now build the content.');
    }

    /**
     * Show the page builder for a product.
     */
    public function edit(Product $product)
    {
        // Get or create product page, then redirect to the unified page builder.
        $page = ProductPage::firstOrCreate(
            ['product_id' => $product->id],
            [
                'slug' => $this->uniqueSlug($product->slug),
                'title' => $product->name,
                'is_published' => false,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]
        );

        return redirect()->route('admin.product-pages.edit', $page);
    }

    /**
     * Show the unified page builder for a ProductPage (standalone or linked).
     */
    public function editPage(ProductPage $page)
    {
        $page->load(['product', 'blocks' => function ($query) {
            $query->with('blockType')->orderBy('sort_order');
        }]);

        $product = $page->product;

        $blockTypes = PageBlockType::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $existingBlocks = $page->blocks;
        $products = Product::orderBy('name')->get();

        return view('admin.products.page-builder', compact(
            'product',
            'page',
            'blockTypes',
            'existingBlocks',
            'products'
        ));
    }

    /**
     * Delete a product page.
     */
    public function destroy(ProductPage $page)
    {
        DB::beginTransaction();
        try {
            PageBlock::where('product_page_id', $page->id)->delete();
            $page->delete();
            DB::commit();

            return redirect()
                ->route('admin.product-pages.index')
                ->with('success', 'Page deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Failed to delete page: ' . $e->getMessage());
        }
    }

    /**
     * Update or create the product page with blocks.
     */
    public function update(Request $request, Product $product)
    {
        $page = ProductPage::where('product_id', $product->id)->first();
        if (!$page) {
            $page = ProductPage::create([
                'product_id' => $product->id,
                'slug' => $this->uniqueSlug($product->slug),
                'title' => $product->name,
                'is_published' => false,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }

        return $this->updatePage($request, $page);
    }

    /**
     * Update or create a ProductPage (standalone or linked) with blocks.
     */
    public function updatePage(Request $request, ProductPage $page)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'blocks' => 'nullable|string',
        ]);

        $productId = $request->input('product_id');
        if ($productId) {
            $existsForProduct = ProductPage::where('product_id', $productId)
                ->where('id', '!=', $page->id)
                ->exists();
            if ($existsForProduct) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'That product already has a page. Please choose another product or keep it standalone.');
            }
        }

        // Decode the blocks JSON string from hidden input
        $blocks = [];
        if ($request->filled('blocks')) {
            $decoded = json_decode($request->input('blocks'), true);
            if (is_array($decoded)) {
                $blocks = $decoded;
            }
        }

        DB::beginTransaction();
        try {
            $page->fill([
                'product_id' => $productId ?: null,
                'slug' => $request->input('slug'),
                'title' => $request->input('title'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'updated_by' => auth()->id(),
            ]);
            $page->save();

            // Delete existing blocks (bypass the is_active scope on relationship)
            PageBlock::where('product_page_id', $page->id)->delete();

            // Create new blocks from decoded JSON
            foreach ($blocks as $index => $blockData) {
                PageBlock::create([
                    'product_page_id' => $page->id,
                    'block_type_id' => $blockData['type_id'],
                    'content' => $blockData['content'] ?? [],
                    'settings' => $blockData['settings'] ?? [],
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.product-pages.edit', $page)
                ->with('success', 'Page saved successfully! ' . count($blocks) . ' block(s) saved.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to save page: ' . $e->getMessage());
        }
    }

    /**
     * Auto-save blocks via AJAX (no page reload).
     */
    public function autoSave(Request $request, Product $product)
    {
        $page = ProductPage::where('product_id', $product->id)->first();
        if (!$page) {
            $page = ProductPage::create([
                'product_id' => $product->id,
                'slug' => $this->uniqueSlug($product->slug),
                'title' => $product->name,
                'is_published' => false,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }

        return $this->autoSavePage($request, $page);
    }

    /**
     * Auto-save blocks for a ProductPage (standalone or linked).
     */
    public function autoSavePage(Request $request, ProductPage $page)
    {
        $blocks = $request->input('blocks', []);

        DB::beginTransaction();
        try {
            PageBlock::where('product_page_id', $page->id)->delete();

            foreach ($blocks as $index => $blockData) {
                PageBlock::create([
                    'product_page_id' => $page->id,
                    'block_type_id' => $blockData['type_id'],
                    'content' => $blockData['content'] ?? [],
                    'settings' => $blockData['settings'] ?? [],
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }

            $page->updated_by = auth()->id();
            $page->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'block_count' => count($blocks),
                'updated_at' => now()->diffForHumans(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Preview the product page.
     */
    public function preview(Product $product)
    {
        $page = $product->productPage;

        if (!$page) {
            abort(404, 'Product page not found. Please save the page first.');
        }

        return $this->previewPage($page);
    }

    /**
     * Preview a ProductPage (standalone or linked).
     */
    public function previewPage(ProductPage $page)
    {
        $product = $page->product?->load(['specifications', 'images', 'category', 'service']);

        $page->load(['blocks' => function ($query) {
            $query->with('blockType')->orderBy('sort_order');
        }]);

        return view('site.product-page', compact('page', 'product'));
    }

    /**
     * Live preview the product page without saving.
     */
    public function previewLive(Request $request, Product $product)
    {
        $page = $product->productPage ?? new ProductPage([
            'product_id' => $product->id,
            'slug' => $product->slug,
            'title' => $product->name,
        ]);

        return $this->previewLivePage($request, $page);
    }

    /**
     * Live preview a ProductPage (standalone or linked) without saving.
     */
    public function previewLivePage(Request $request, ProductPage $page)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'blocks' => 'nullable|string',
        ]);

        $productId = $request->input('product_id');
        $product = $productId ? Product::with(['specifications', 'images', 'category', 'service'])->find($productId) : $page->product?->load(['specifications', 'images', 'category', 'service']);

        $blocks = [];
        if ($request->filled('blocks')) {
            $decoded = json_decode($request->input('blocks'), true);
            if (is_array($decoded)) {
                $blocks = $decoded;
            }
        }

        $page = new ProductPage([
            'product_id' => $productId ?: $page->product_id,
            'slug' => $request->input('slug', $page->slug),
            'title' => $request->input('title', $page->title),
            'meta_title' => $request->input('meta_title', $page->meta_title),
            'meta_description' => $request->input('meta_description', $page->meta_description),
            'is_published' => false,
        ]);

        $blockModels = collect($blocks)->map(function ($blockData, $index) {
            $blockType = PageBlockType::find($blockData['type_id'] ?? null);
            if (!$blockType) {
                return null;
            }

            $block = new PageBlock([
                'block_type_id' => $blockType->id,
                'content' => $blockData['content'] ?? [],
                'settings' => $blockData['settings'] ?? [],
                'sort_order' => $index,
                'is_active' => true,
            ]);

            $block->setRelation('blockType', $blockType);

            return $block;
        })->filter()->values();

        $page->setRelation('blocks', $blockModels);

        return view('site.product-page', compact('page', 'product'));
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(Product $product)
    {
        $page = $product->productPage;

        if (!$page) {
            return response()->json(['error' => 'Product page not found'], 404);
        }

        return $this->togglePublishPage($page);
    }

    /**
     * Toggle publish status for a ProductPage.
     */
    public function togglePublishPage(ProductPage $page)
    {
        $page->is_published = !$page->is_published;
        $page->published_at = $page->is_published ? now() : null;
        $page->save();

        return response()->json([
            'success' => true,
            'is_published' => $page->is_published,
            'message' => $page->is_published ? 'Page published successfully' : 'Page unpublished successfully',
        ]);
    }

    /**
     * Upload an image for the page builder blocks.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $path = $request->file('image')->store('page-builder', 'public');

        return response()->json([
            'success' => true,
            'path' => 'storage/' . $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    private function uniqueSlug(string $slug): string
    {
        $base = Str::slug($slug);
        if ($base === '') {
            $base = 'page';
        }
        $final = $base;
        $i = 1;
        while (ProductPage::where('slug', $final)->exists()) {
            $final = $base . '-' . $i;
            $i++;
        }

        return $final;
    }
}
