<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('site.services', compact('services'));
    }

    /**
     * Display the specified service.
     */
    public function show($slug)
    {
        $service = Service::with('details')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get all services for the sidebar
        $allServices = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get related products for this service
        $relatedProducts = $service->products()
            ->where('is_active', true)
            ->with('productPage')
            ->limit(4)
            ->get();

        return view('site.service_single', compact('service', 'allServices', 'relatedProducts'));
    }
}
