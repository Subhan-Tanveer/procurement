<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\SupplierApplication;
use App\Models\SupplierApplicationProduct;
use App\Models\SupplierProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = SupplierApplication::with(['approvedSupplierProfile', 'reviewedBy'])->withCount('products')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('application_number', 'like', $term)
                    ->orWhere('organization_name', 'like', $term)
                    ->orWhere('contact_name', 'like', $term)
                    ->orWhere('contact_email', 'like', $term);
            });
        }

        $applications = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => SupplierApplication::count(),
            'submitted' => SupplierApplication::where('status', 'submitted')->count(),
            'under_review' => SupplierApplication::where('status', 'under_review')->count(),
            'approved' => SupplierApplication::where('status', 'approved')->count(),
            'rejected' => SupplierApplication::where('status', 'rejected')->count(),
            'changes_requested' => SupplierApplication::where('status', 'changes_requested')->count(),
        ];

        return view('admin.supplier-applications.index', compact('applications', 'counts'));
    }

    public function show(SupplierApplication $application)
    {
        $application->load([
            'products.category',
            'products.service',
            'products.specifications',
            'products.images',
            'products.reviewedBy',
            'products.convertedProduct',
            'approvedSupplierProfile',
            'reviewedBy',
        ]);

        return view('admin.supplier-applications.show', compact('application'));
    }

    public function approve(Request $request, SupplierApplication $application)
    {
        $request->validate([
            'review_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $profile = $application->approvedSupplierProfile;

        if (!$profile) {
            $profile = SupplierProfile::create([
                'user_id' => null,
                'organization_name' => $application->organization_name,
                'slug' => $application->slug,
                'contact_name' => $application->contact_name,
                'contact_email' => $application->contact_email,
                'contact_phone' => $application->contact_phone,
                'category' => $application->category,
                'business_address' => $application->business_address,
                'business_phone' => $application->business_phone,
                'website' => $application->website,
                'description' => $application->description,
                'logo' => $application->logo,
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'review_notes' => $request->input('review_notes'),
            ]);
        } else {
            $profile->update([
                'organization_name' => $application->organization_name,
                'contact_name' => $application->contact_name,
                'contact_email' => $application->contact_email,
                'contact_phone' => $application->contact_phone,
                'category' => $application->category,
                'business_address' => $application->business_address,
                'business_phone' => $application->business_phone,
                'website' => $application->website,
                'description' => $application->description,
                'logo' => $application->logo,
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'review_notes' => $request->input('review_notes'),
            ]);
        }

        $application->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->input('review_notes'),
            'approved_supplier_profile_id' => $profile->id,
        ]);

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Supplier application approved and supplier profile created.');
    }

    public function reject(Request $request, SupplierApplication $application)
    {
        $request->validate([
            'review_notes' => ['required', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->input('review_notes'),
        ]);

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Supplier application rejected.');
    }

    public function requestChanges(Request $request, SupplierApplication $application)
    {
        $request->validate([
            'review_notes' => ['required', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => 'changes_requested',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->input('review_notes'),
        ]);

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Changes requested on supplier application.');
    }

    public function approveProduct(Request $request, SupplierApplication $application, SupplierApplicationProduct $product)
    {
        abort_unless($product->supplier_application_id === $application->id, 404);

        $product->update([
            'status' => 'approved',
            'review_notes' => $request->input('review_notes'),
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        if ($application->status === 'submitted') {
            $application->update([
                'status' => 'under_review',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        }

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Submitted product approved for conversion.');
    }

    public function rejectProduct(Request $request, SupplierApplication $application, SupplierApplicationProduct $product)
    {
        abort_unless($product->supplier_application_id === $application->id, 404);

        $request->validate([
            'review_notes' => ['required', 'string', 'max:1000'],
        ]);

        $product->update([
            'status' => 'rejected',
            'review_notes' => $request->input('review_notes'),
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        if ($application->status === 'submitted') {
            $application->update([
                'status' => 'under_review',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        }

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Submitted product rejected.');
    }

    public function convertProduct(SupplierApplication $application, SupplierApplicationProduct $product)
    {
        abort_unless($product->supplier_application_id === $application->id, 404);

        if ($product->status !== 'approved') {
            return redirect()->route('admin.supplier-applications.show', $application)
                ->with('error', 'Approve this submitted product before conversion.');
        }

        if (!$application->approved_supplier_profile_id) {
            return redirect()->route('admin.supplier-applications.show', $application)
                ->with('error', 'Approve the supplier application before converting products.');
        }

        if ($product->converted_product_id) {
            return redirect()->route('admin.supplier-applications.show', $application)
                ->with('info', 'This submitted product has already been converted.');
        }

        DB::transaction(function () use ($application, $product) {
            $supplierPriceNote = $product->price
                ? ' Supplier submitted reference price: ' . ($product->currency ?: 'NGN') . ' ' . number_format((float) $product->price, 2) . '.'
                : '';

            $catalogProduct = Product::create([
                'supplier_id' => $application->approved_supplier_profile_id,
                'category_id' => $product->category_id,
                'service_id' => $product->service_id,
                'name' => $product->name,
                'slug' => $this->uniqueProductSlug($product->name),
                'sku' => $product->sku,
                'short_description' => $product->short_description,
                'description' => $product->description,
                'price' => null,
                'currency' => null,
                'featured_image' => $product->featured_image ?: $product->images->first()?->image_path,
                'is_featured' => false,
                'is_active' => false,
                'stock_status' => $product->stock_status ?: 'in_stock',
                'meta_title' => $product->name,
                'meta_description' => $product->short_description,
                'approval_status' => 'approved',
                'approval_notes' => 'Converted from supplier application ' . $application->application_number . '.' . $supplierPriceNote,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            foreach ($product->specifications as $spec) {
                ProductSpecification::create([
                    'product_id' => $catalogProduct->id,
                    'name' => $spec->name,
                    'value' => $spec->value,
                    'unit' => $spec->unit,
                    'sort_order' => $spec->sort_order,
                ]);
            }

            foreach ($product->images as $index => $image) {
                ProductImage::create([
                    'product_id' => $catalogProduct->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text ?: $catalogProduct->name,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }

            $product->update([
                'status' => 'converted',
                'converted_product_id' => $catalogProduct->id,
                'converted_at' => now(),
            ]);
        });

        return redirect()->route('admin.supplier-applications.show', $application)
            ->with('success', 'Submitted product converted into a catalog draft successfully.');
    }

    private function uniqueProductSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
