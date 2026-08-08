<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = SupplierProfile::with(['user', 'reviewedBy'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';

            $query->where(function ($q) use ($term) {
                $q->where('organization_name', 'like', $term)
                    ->orWhere('contact_name', 'like', $term)
                    ->orWhere('contact_email', 'like', $term)
                    ->orWhere('contact_phone', 'like', $term)
                    ->orWhere('business_phone', 'like', $term)
                    ->orWhereHas('user', fn ($u) => $u->where('email', 'like', $term)->orWhere('name', 'like', $term));
            });
        }

        $suppliers = $query->paginate(20)->withQueryString();

        $counts = [
            'all'            => SupplierProfile::count(),
            'pending_review' => SupplierProfile::where('status', 'pending_review')->count(),
            'approved'       => SupplierProfile::where('status', 'approved')->count(),
            'rejected'       => SupplierProfile::where('status', 'rejected')->count(),
            'suspended'      => SupplierProfile::where('status', 'suspended')->count(),
        ];

        return view('admin.suppliers.index', compact('suppliers', 'counts'));
    }

    public function show(SupplierProfile $supplier)
    {
        $supplier->load([
            'user',
            'reviewedBy',
            'products' => fn ($q) => $q->with(['category', 'service'])->latest()->take(10),
        ]);

        return view('admin.suppliers.show', compact('supplier'));
    }

    public function approve(Request $request, SupplierProfile $supplier)
    {
        $supplier->update([
            'status'      => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes'=> $request->input('review_notes'),
        ]);

        return redirect()->route('admin.suppliers.show', $supplier)
            ->with('success', 'Supplier approved successfully.');
    }

    public function reject(Request $request, SupplierProfile $supplier)
    {
        $request->validate([
            'review_notes' => ['required', 'string', 'max:1000'],
        ]);

        $supplier->update([
            'status'       => 'rejected',
            'reviewed_by'  => Auth::id(),
            'reviewed_at'  => now(),
            'review_notes' => $request->review_notes,
        ]);

        return redirect()->route('admin.suppliers.show', $supplier)
            ->with('success', 'Supplier rejected.');
    }

    public function suspend(Request $request, SupplierProfile $supplier)
    {
        $supplier->update([
            'status'       => 'suspended',
            'reviewed_by'  => Auth::id(),
            'reviewed_at'  => now(),
            'review_notes' => $request->input('review_notes'),
        ]);

        return redirect()->route('admin.suppliers.show', $supplier)
            ->with('success', 'Supplier suspended.');
    }
}
