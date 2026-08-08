<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\SupplierApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::query()->orderBy('title')->get(['id', 'title']);

        return view('supplier.auth.register', compact('categories', 'services'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'organization_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'business_address' => ['nullable', 'string', 'max:1000'],
            'business_phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'logo' => ['nullable', 'image', 'max:5120'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.name' => ['required', 'string', 'max:255'],
            'products.*.category_id' => ['nullable', 'exists:product_categories,id'],
            'products.*.service_id' => ['nullable', 'exists:services,id'],
            'products.*.sku' => ['nullable', 'string', 'max:255'],
            'products.*.short_description' => ['nullable', 'string', 'max:500'],
            'products.*.description' => ['nullable', 'string'],
            'products.*.price' => ['nullable', 'numeric', 'min:0'],
            'products.*.currency' => ['nullable', 'string', 'max:3'],
            'products.*.stock_status' => ['nullable', 'in:in_stock,out_of_stock,on_backorder'],
            'products.*.featured_image' => ['nullable', 'image', 'max:5120'],
            'products.*.specs' => ['nullable', 'array'],
            'products.*.specs.*.name' => ['required_with:products.*.specs', 'string', 'max:255'],
            'products.*.specs.*.value' => ['required_with:products.*.specs', 'string', 'max:255'],
            'products.*.specs.*.unit' => ['nullable', 'string', 'max:60'],
            'products.*.images' => ['nullable', 'array', 'max:10'],
            'products.*.images.*' => ['image', 'max:5120'],
        ]);

        DB::beginTransaction();

        try {
            $applicationData = [
                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'] ?? null,
                'organization_name' => $validated['organization_name'],
                'slug' => Str::slug($validated['organization_name']) . '-' . Str::lower(Str::random(6)),
                'category' => $validated['category'] ?? null,
                'business_address' => $validated['business_address'] ?? null,
                'business_phone' => $validated['business_phone'] ?? null,
                'website' => $validated['website'] ?? null,
                'description' => $validated['description'] ?? null,
                'status' => 'submitted',
                'submitted_at' => now(),
            ];

            if ($request->hasFile('logo')) {
                $applicationData['logo'] = 'storage/' . $request->file('logo')->store('supplier-applications/logos', 'public');
            }

            $application = SupplierApplication::create($applicationData);

            foreach ($validated['products'] as $productIndex => $productData) {
                $productPayload = [
                    'supplier_application_id' => $application->id,
                    'category_id' => $productData['category_id'] ?? null,
                    'service_id' => $productData['service_id'] ?? null,
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']) . '-' . Str::lower(Str::random(6)),
                    'sku' => $productData['sku'] ?? null,
                    'short_description' => $productData['short_description'] ?? null,
                    'description' => $productData['description'] ?? null,
                    'price' => $productData['price'] ?? null,
                    'currency' => $productData['currency'] ?? 'NGN',
                    'stock_status' => $productData['stock_status'] ?? 'in_stock',
                    'status' => 'submitted',
                ];

                if ($request->hasFile("products.$productIndex.featured_image")) {
                    $productPayload['featured_image'] = 'storage/' . $request->file("products.$productIndex.featured_image")->store('supplier-applications/products', 'public');
                }

                $product = $application->products()->create($productPayload);

                foreach ($productData['specs'] ?? [] as $specIndex => $spec) {
                    if (blank($spec['name'] ?? null) && blank($spec['value'] ?? null)) {
                        continue;
                    }

                    $product->specifications()->create([
                        'name' => $spec['name'],
                        'value' => $spec['value'],
                        'unit' => $spec['unit'] ?? null,
                        'sort_order' => $specIndex,
                    ]);
                }

                if ($request->hasFile("products.$productIndex.images")) {
                    foreach ($request->file("products.$productIndex.images") as $imageIndex => $image) {
                        $product->images()->create([
                            'image_path' => 'storage/' . $image->store('supplier-applications/products', 'public'),
                            'alt_text' => $product->name,
                            'sort_order' => $imageIndex,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('supplier.success')
                ->with('application_number', $application->application_number);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Supplier application submission failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to submit supplier application right now. Please try again.');
        }
    }

    public function success()
    {
        $applicationNumber = session('application_number');

        if (!$applicationNumber) {
            return redirect()->route('supplier.register');
        }

        return view('supplier.success', compact('applicationNumber'));
    }

    public function pending()
    {
        $profile = Auth::user()?->supplierProfile;

        return view('supplier.pending', compact('profile'));
    }
}
