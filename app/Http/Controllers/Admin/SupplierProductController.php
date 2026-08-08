<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::supplierOwned()
            ->with(['supplier.user', 'category', 'images'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        } else {
            $query->where('approval_status', 'pending');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20)->withQueryString();

        $counts = [
            'pending'  => Product::supplierOwned()->where('approval_status', 'pending')->count(),
            'approved' => Product::supplierOwned()->where('approval_status', 'approved')->count(),
            'rejected' => Product::supplierOwned()->where('approval_status', 'rejected')->count(),
        ];

        return view('admin.supplier-products.index', compact('products', 'counts'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->supplier_id, 404);
        $product->load(['supplier.user', 'specifications', 'images', 'category', 'approvedByUser']);

        return view('admin.supplier-products.show', compact('product'));
    }

    public function approve(Request $request, Product $product)
    {
        abort_if(!$product->supplier_id, 404);

        $product->update([
            'approval_status' => 'approved',
            'approval_notes'  => null,
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
            'is_active'       => true,
        ]);

        return redirect()->route('admin.supplier-products.show', $product)
            ->with('success', 'Product approved and is now live.');
    }

    public function reject(Request $request, Product $product)
    {
        abort_if(!$product->supplier_id, 404);

        $request->validate([
            'approval_notes' => ['required', 'string', 'max:1000'],
        ]);

        $product->update([
            'approval_status' => 'rejected',
            'approval_notes'  => $request->approval_notes,
            'is_active'       => false,
        ]);

        return redirect()->route('admin.supplier-products.show', $product)
            ->with('success', 'Product rejected.');
    }
}
