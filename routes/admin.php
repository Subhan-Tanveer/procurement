<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductPageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\QuotationController as AdminQuotationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AssignedRoleController as AdminAssignedRoleController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\MarketingTemplateController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\SupplierProductController as AdminSupplierProductController;
use App\Http\Controllers\Admin\SupplierApplicationController as AdminSupplierApplicationController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.access'])->group(function () {

    // ── Dashboards ─────────────────────────────────────────────────────────
    Route::get('/dashboard',        [DashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')->name('dashboard');
    Route::get('/dashboard/sales',  [DashboardController::class, 'sales'])
        ->middleware('permission:dashboard.view')->name('dashboard.sales');
    Route::get('/dashboard/finance',[DashboardController::class, 'finance'])
        ->middleware('permission:dashboard.view')->name('dashboard.finance');

    // ── Categories ──────────────────────────────────────────────────────────
    Route::resource('categories', ProductCategoryController::class)
        ->except(['create', 'show', 'edit'])
        ->middleware('permission:categories.manage');

    // ── Services ────────────────────────────────────────────────────────────
    Route::resource('services', AdminServiceController::class)
        ->except(['show'])
        ->middleware('permission:services.manage');

    // ── Products ─────────────────────────────────────────────────────────────
    Route::resource('products', AdminProductController::class)
        ->middleware('permission:products.manage');

    // ── Page Builder (standalone pages) ──────────────────────────────────────
    Route::prefix('product-pages')->name('product-pages.')->middleware('permission:product_pages.manage')
        ->group(function () {
            Route::get('/',                    [ProductPageController::class, 'index'])->name('index');
            Route::post('/',                   [ProductPageController::class, 'store'])->name('store');
            Route::get('/{page}/edit',         [ProductPageController::class, 'editPage'])->name('edit');
            Route::put('/{page}',              [ProductPageController::class, 'updatePage'])->name('update');
            Route::delete('/{page}',           [ProductPageController::class, 'destroy'])->name('destroy');
            Route::get('/{page}/preview',      [ProductPageController::class, 'previewPage'])->name('preview');
            Route::post('/{page}/preview-live',[ProductPageController::class, 'previewLivePage'])->name('preview-live');
            Route::post('/{page}/toggle-publish',[ProductPageController::class,'togglePublishPage'])->name('toggle-publish');
            Route::post('/{page}/auto-save',   [ProductPageController::class, 'autoSavePage'])->name('auto-save');
        });

    // ── Page Builder (legacy product-linked routes) ────────────────────────
    Route::prefix('products')->name('products.page.')->middleware('permission:product_pages.manage')
        ->group(function () {
            Route::post('/page/upload-image',            [ProductPageController::class, 'uploadImage'])->name('upload-image');
            Route::get('/{product}/page/edit',           [ProductPageController::class, 'edit'])->name('edit');
            Route::put('/{product}/page',                [ProductPageController::class, 'update'])->name('update');
            Route::get('/{product}/page/preview',        [ProductPageController::class, 'preview'])->name('preview');
            Route::post('/{product}/page/preview-live',  [ProductPageController::class, 'previewLive'])->name('preview-live');
            Route::post('/{product}/page/toggle-publish',[ProductPageController::class, 'togglePublish'])->name('toggle-publish');
            Route::post('/{product}/page/auto-save',     [ProductPageController::class, 'autoSave'])->name('auto-save');
        });

    // ── Marketing Templates ───────────────────────────────────────────────
    Route::get('marketing-templates', [MarketingTemplateController::class, 'index'])
        ->middleware('permission:marketing_templates.manage')
        ->name('marketing-templates.index');

    // ── Quotations ────────────────────────────────────────────────────────
    Route::prefix('quotations')->name('quotations.')->group(function () {
        Route::get('/',                            [AdminQuotationController::class, 'index'])
            ->middleware('permission:quotations.view')->name('index');
        Route::get('/{quotation}',                 [AdminQuotationController::class, 'show'])
            ->middleware('permission:quotations.view')->name('show');
        Route::delete('/{quotation}',              [AdminQuotationController::class, 'destroy'])
            ->middleware('permission:quotations.update')->name('destroy');
        Route::patch('/{quotation}/status',        [AdminQuotationController::class, 'updateStatus'])
            ->middleware('permission:quotations.update')->name('update-status');
        Route::patch('/{quotation}/mark-paid',     [AdminQuotationController::class, 'markPaid'])
            ->middleware('permission:quotations.mark_paid')->name('mark-paid');
        Route::post('/{quotation}/convert-to-order',[AdminQuotationController::class, 'convertToOrder'])
            ->middleware('permission:quotations.convert_to_order')->name('convert-to-order');
    });

    // ── Orders ─────────────────────────────────────────────────────────────
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',                 [AdminOrderController::class, 'index'])
            ->middleware('permission:orders.view')->name('index');
        Route::get('/{order}',          [AdminOrderController::class, 'show'])
            ->middleware('permission:orders.view')->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->middleware('permission:orders.update')->name('update-status');
    });

    // ── Users ───────────────────────────────────────────────────────────────
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',            [AdminUserController::class, 'index'])
            ->middleware('permission:users.view')->name('index');
        Route::get('/create',      [AdminUserController::class, 'create'])
            ->middleware('permission:users.create')->name('create');
        Route::post('/',           [AdminUserController::class, 'store'])
            ->middleware('permission:users.create')->name('store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])
            ->middleware('permission:users.update,users.assign_roles')->name('edit');
        Route::put('/{user}',      [AdminUserController::class, 'update'])
            ->middleware('permission:users.update,users.assign_roles')->name('update');
    });

    // ── My Profile ──────────────────────────────────────────────────────────
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
        Route::put('/', [AdminProfileController::class, 'update'])->name('update');
        Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    });

    // ── Assigned Roles ──────────────────────────────────────────────────────
    Route::prefix('assigned-roles')->name('assigned-roles.')->group(function () {
        Route::get('/',                    [AdminAssignedRoleController::class, 'index'])
            ->middleware('permission:assigned_roles.view')->name('index');
        Route::get('/create',              [AdminAssignedRoleController::class, 'create'])
            ->middleware('permission:assigned_roles.create')->name('create');
        Route::post('/',                   [AdminAssignedRoleController::class, 'store'])
            ->middleware('permission:assigned_roles.create')->name('store');
        Route::get('/{assignedRole}/edit', [AdminAssignedRoleController::class, 'edit'])
            ->middleware('permission:assigned_roles.update,assigned_roles.assign_permissions')->name('edit');
        Route::put('/{assignedRole}',      [AdminAssignedRoleController::class, 'update'])
            ->middleware('permission:assigned_roles.update,assigned_roles.assign_permissions')->name('update');
    });

    // ── Supplier Applications ───────────────────────────────────────────────
    Route::prefix('supplier-applications')->name('supplier-applications.')->group(function () {
        Route::get('/', [AdminSupplierApplicationController::class, 'index'])
            ->middleware('permission:suppliers.view')->name('index');
        Route::get('/{application}', [AdminSupplierApplicationController::class, 'show'])
            ->middleware('permission:suppliers.view')->name('show');
        Route::patch('/{application}/approve', [AdminSupplierApplicationController::class, 'approve'])
            ->middleware('permission:suppliers.manage')->name('approve');
        Route::patch('/{application}/reject', [AdminSupplierApplicationController::class, 'reject'])
            ->middleware('permission:suppliers.manage')->name('reject');
        Route::patch('/{application}/request-changes', [AdminSupplierApplicationController::class, 'requestChanges'])
            ->middleware('permission:suppliers.manage')->name('request-changes');
        Route::patch('/{application}/products/{product}/approve', [AdminSupplierApplicationController::class, 'approveProduct'])
            ->middleware('permission:suppliers.manage')->name('products.approve');
        Route::patch('/{application}/products/{product}/reject', [AdminSupplierApplicationController::class, 'rejectProduct'])
            ->middleware('permission:suppliers.manage')->name('products.reject');
        Route::post('/{application}/products/{product}/convert', [AdminSupplierApplicationController::class, 'convertProduct'])
            ->middleware('permission:products.manage')->name('products.convert');
    });

    // ── Approved Suppliers ──────────────────────────────────────────────────
    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/',                              [AdminSupplierController::class, 'index'])
            ->middleware('permission:suppliers.view')->name('index');
        Route::get('/{supplier}',                    [AdminSupplierController::class, 'show'])
            ->middleware('permission:suppliers.view')->name('show');
        Route::patch('/{supplier}/approve',          [AdminSupplierController::class, 'approve'])
            ->middleware('permission:suppliers.manage')->name('approve');
        Route::patch('/{supplier}/reject',           [AdminSupplierController::class, 'reject'])
            ->middleware('permission:suppliers.manage')->name('reject');
        Route::patch('/{supplier}/suspend',          [AdminSupplierController::class, 'suspend'])
            ->middleware('permission:suppliers.manage')->name('suspend');
    });

    // ── Supplier Products (legacy approval queue) ───────────────────────────
    Route::prefix('supplier-products')->name('supplier-products.')->group(function () {
        Route::get('/',                              [AdminSupplierProductController::class, 'index'])
            ->middleware('permission:supplier_products.approve')->name('index');
        Route::get('/{product}',                     [AdminSupplierProductController::class, 'show'])
            ->middleware('permission:supplier_products.approve')->name('show');
        Route::patch('/{product}/approve',           [AdminSupplierProductController::class, 'approve'])
            ->middleware('permission:supplier_products.approve')->name('approve');
        Route::patch('/{product}/reject',            [AdminSupplierProductController::class, 'reject'])
            ->middleware('permission:supplier_products.approve')->name('reject');
    });

    // ── Media Library ───────────────────────────────────────────────────────
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/',      [AdminMediaController::class, 'index'])->name('index');
        Route::post('/upload',[AdminMediaController::class, 'upload'])->name('upload');
    });

});
