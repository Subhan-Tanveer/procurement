<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->supplierProfile;

        $stats = [
            'total'    => Product::where('supplier_id', $profile->id)->count(),
            'pending'  => Product::where('supplier_id', $profile->id)->where('approval_status', 'pending')->count(),
            'approved' => Product::where('supplier_id', $profile->id)->where('approval_status', 'approved')->count(),
            'rejected' => Product::where('supplier_id', $profile->id)->where('approval_status', 'rejected')->count(),
        ];

        $recentProducts = Product::where('supplier_id', $profile->id)
            ->latest()
            ->take(5)
            ->get();

        return view('supplier.dashboard', compact('profile', 'stats', 'recentProducts'));
    }
}
