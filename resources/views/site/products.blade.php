@extends('site.master_layout')

@section('title', 'Our Products')
@section('description', 'Browse quality products for Oil & Gas, Construction, Technology, and Corporate procurement, sourced and delivered by Good Procurement Service Ltd.')

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-products.css') }}">
@endpush

@section('main')
<div class="page-header-elite gps-products-hero bg-section">
    <video class="gps-hero-video" autoplay muted loop playsinline preload="none" aria-hidden="true">
        <source src="{{ asset('site/assets/videos/hero-products.mp4') }}" type="video/mp4">
    </video>
    <div class="gps-video-overlay" aria-hidden="true"></div>
    <div class="container">
        <span class="gps-products-eyebrow">Product Catalogue</span>
        <h1 class="gps-products-title text-anime-style-3" data-cursor="-opaque">Our Products</h1>
        <p class="gps-products-sub wow fadeInUp" data-wow-delay="0.2s">
            Discover our comprehensive range of quality products for Oil &amp; Gas, Construction, and Corporate sectors.
        </p>
        <div class="gps-products-stats wow fadeInUp" data-wow-delay="0.3s">
            <div class="gps-stat">
                <span class="gps-stat-num">{{ $products->total() }}</span>
                <span class="gps-stat-label">Products Available</span>
            </div>
            <div class="gps-stat">
                <span class="gps-stat-num">{{ $categories->count() }}</span>
                <span class="gps-stat-label">Categories</span>
            </div>
        </div>
    </div>
</div>

<!-- Product Filters -->
<div class="gps-filters">
    <div class="container">
        <form method="GET" action="{{ route('products.index') }}" class="gps-filter-form">
            <div class="gps-filter-field">
                <label class="gps-filter-label">
                    <i class="fa-solid fa-layer-group"></i>Category
                </label>
                <select name="category" class="gps-filter-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="gps-filter-field">
                <label class="gps-filter-label">
                    <i class="fa-solid fa-briefcase"></i>Service Type
                </label>
                <select name="service" class="gps-filter-select" onchange="this.form.submit()">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                            {{ request('service') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="gps-filter-field">
                <label class="gps-filter-label">
                    <i class="fa-solid fa-search"></i>Search Products
                </label>
                <input type="text"
                       name="search"
                       class="gps-filter-input"
                       placeholder="Search by name, SKU, or description..."
                       value="{{ request('search') }}">
            </div>

            <div class="gps-filter-actions">
                <button type="submit" class="btn-default">
                    <i class="fa-solid fa-filter me-2"></i> Apply
                </button>
                @if(request()->hasAny(['category', 'service', 'search']))
                    <a href="{{ route('products.index') }}" class="gps-filter-clear">
                        <i class="fa-solid fa-rotate-right me-1"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="gps-products-grid-section">
    <div class="container">
        @if($products->count() > 0)
            <div class="gps-products-grid">
                @foreach($products as $product)
                    <div class="gps-product-card wow fadeInUp" data-wow-delay="{{ 0.1 * ($loop->iteration % 4) }}s">
                        @if($product->productPage && $product->productPage->is_published)
                            <a href="{{ route('products.show', $product->productPage->slug) }}" class="gps-product-card-link">
                        @else
                            <div class="gps-product-card-link gps-product-card-disabled">
                        @endif
                                <!-- Product Image -->
                                <div class="gps-product-card-media">
                                    @if($product->featured_image)
                                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}">
                                    @elseif(file_exists(public_path('site/assets/images/product-placeholder.jpg')))
                                        <img src="{{ asset('site/assets/images/product-placeholder.jpg') }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80" alt="{{ $product->name }}">
                                    @endif

                                    @if($product->is_featured)
                                        <span class="gps-badge">
                                            <i class="fa-solid fa-star"></i>Featured
                                        </span>
                                    @endif

                                    @if(!$product->productPage || !$product->productPage->is_published)
                                        <span class="gps-badge gps-badge-soon">
                                            <i class="fa-solid fa-hourglass-half"></i>Coming Soon
                                        </span>
                                    @elseif($product->stock_status)
                                        <span class="gps-badge gps-badge-stock gps-stock-{{ $product->stock_status }}">
                                            {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Content -->
                                <div class="gps-product-card-body">
                                    @if($product->category)
                                        <div class="gps-product-meta">
                                            <span class="gps-product-tag">
                                                <i class="fa-solid fa-folder me-1"></i>{{ $product->category->name }}
                                            </span>
                                            @if($product->service)
                                                <span class="gps-product-tag">
                                                    <i class="fa-solid fa-briefcase me-1"></i>{{ $product->service->name }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <h3 class="gps-product-title">{{ $product->name }}</h3>

                                    @if($product->sku)
                                        <div class="gps-product-sku">SKU: {{ $product->sku }}</div>
                                    @endif

                                    @if($product->short_description)
                                        <p class="gps-product-desc">{{ Str::limit($product->short_description, 80) }}</p>
                                    @endif

                                    <div class="gps-product-footer">
                                        @if($product->price > 0)
                                            <div class="gps-product-price">
                                                <span class="gps-product-price-currency">{{ $product->currency ?? 'NGN' }}</span>
                                                <span>{{ number_format($product->price, 2) }}</span>
                                            </div>
                                        @else
                                            <div class="gps-product-price-request">Price on Request</div>
                                        @endif
                                        <span class="gps-product-cta">
                                            {{ $product->productPage && $product->productPage->is_published ? 'View Details' : 'Coming Soon' }}
                                        </span>
                                    </div>
                                </div>
                        @if($product->productPage && $product->productPage->is_published)
                            </a>
                        @else
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="gps-pagination wow fadeInUp">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="gps-empty-state wow fadeIn">
                <div class="gps-empty-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="gps-empty-title">No Products Found</h3>
                <p class="gps-empty-text">We couldn't find any products matching your criteria.
                Try adjusting your filters or search terms.</p>
                <a href="{{ route('products.index') }}" class="btn-default">
                    <i class="fa-solid fa-rotate-right me-2"></i> Clear All Filters
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
