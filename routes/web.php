<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\OrderTrackingController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

// ── Public Pages ────────────────────────────────────────────────────────────
Route::view('/', 'site.welcome')->name('home');
Route::redirect('/about', '/');
Route::view('/blog', 'site.blog')->name('blog');
Route::view('/blog-details', 'site.blog_single')->name('blog.details');

Route::view('/privacy-policy', 'site.privacy_policy')->name('privacy');
Route::view('/terms-of-service', 'site.terms')->name('terms');

Route::get('/robots.txt', function () {
    $lines = [
        'User-agent: *',
        'Disallow: /admin',
        'Disallow: /staff/login',
        'Disallow: /register',
        'Disallow: /supplier',
        'Disallow: /track-order',
        'Disallow: /quotation-success',
        '',
        'Sitemap: ' . route('sitemap'),
    ];

    return response(implode("\n", $lines), 200)->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))->setPriority(1.0))
        ->add(Url::create(route('services'))->setPriority(0.8))
        ->add(Url::create(route('products.index'))->setPriority(0.8))
        ->add(Url::create(route('privacy'))->setPriority(0.2))
        ->add(Url::create(route('terms'))->setPriority(0.2));

    Service::where('is_active', true)->get()->each(function ($service) use ($sitemap) {
        $sitemap->add(Url::create(route('services.show', $service->slug))->setPriority(0.7));
    });

    // Individual product pages are a "coming soon" placeholder for now (see
    // ProductController), so they're left out of the sitemap to avoid indexing
    // many URLs with identical content.

    return $sitemap->toResponse(request());
})->name('sitemap');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ── Quotations (public) ─────────────────────────────────────────────────────
Route::post('/quotations', [QuotationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('quotations.store');
Route::get('/quotation-success', [QuotationController::class, 'success'])->name('quotations.success');

// ── Order Tracking (public) ─────────────────────────────────────────────────
Route::get('/track-order',  [OrderTrackingController::class, 'show'])->name('orders.track');
Route::post('/track-order', [OrderTrackingController::class, 'track'])
    ->middleware('throttle:20,1')
    ->name('orders.track.submit');

// ── Authentication ──────────────────────────────────────────────────────────
Route::get('/auth/login', fn () => abort(404));
Route::match(['get', 'post'], '/login', fn () => abort(404));
Route::match(['get', 'post'], '/register', fn () => abort(404));

Route::middleware('guest')->group(function () {
    Route::get('/staff/login',  [AuthController::class, 'showLoginForm'])->name('staff.login');
    Route::post('/staff/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('staff.login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
