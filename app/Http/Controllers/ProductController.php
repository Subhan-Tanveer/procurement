<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * The product catalog isn't ready for real customer traffic yet -- both the
     * listing and every product slug show a "coming soon" placeholder instead of
     * the seeded placeholder catalog, so visitors never see fake products or a 404.
     */
    public function index(Request $request)
    {
        return view('site.products_coming_soon');
    }

    /**
     * Display the specified product page.
     */
    public function show($slug)
    {
        return view('site.products_coming_soon');
    }
}
