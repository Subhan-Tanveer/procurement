@extends('site.master_layout')

@section('title', $page->meta_title ?? $page->title)

@section('description', $page->meta_description ?? optional($product)->short_description ?? 'View product details, specifications, and request a quote from Good Procurement Service Ltd.')

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-products.css') }}">
@endpush

@section('main')

{{-- Render each block in order --}}
<div class="page-builder-blocks">
    @foreach($page->blocks as $block)
        @include("blocks.{$block->blockType->component_name}", [
            'content' => $block->content,
            'settings' => $block->settings,
            'product' => $product,
            'blockType' => $block->blockType,
        ])
    @endforeach
</div>

{{-- Product Specifications Section --}}
@if($product && $product->specifications->count() > 0)
    <div class="gps-specs-section">
        <div class="container">
            <div class="gps-section-head gps-center">
                <span class="gps-section-eyebrow wow fadeInUp">Product Details</span>
                <h2 class="gps-section-title text-anime-style-3" data-cursor="-opaque">Technical Specifications</h2>
            </div>

            <div class="gps-specs-table">
                @foreach($product->specifications as $spec)
                    <div class="gps-spec-row wow fadeInUp" data-wow-delay="{{ 0.05 * $loop->iteration }}s">
                        <div class="gps-spec-name">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>{{ $spec->name }}</span>
                        </div>
                        <div class="gps-spec-value">
                            {{ $spec->value }}
                            @if($spec->unit)
                                <span class="gps-spec-unit">{{ $spec->unit }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{-- Product Gallery --}}
@if($product && $product->images->count() > 0)
    <div class="gps-gallery-section">
        <div class="container">
            <div class="gps-section-head gps-center">
                <span class="gps-section-eyebrow wow fadeInUp">Gallery</span>
                <h2 class="gps-section-title text-anime-style-3" data-cursor="-opaque">Product Gallery</h2>
            </div>

            <div class="gps-gallery-grid">
                @foreach($product->images as $image)
                    <div class="gps-gallery-item wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text ?? $product->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{-- Quote Form Section --}}
@if($product)
<div class="gps-quote-section">
    <div class="container">
        <div class="gps-section-head gps-center">
            <span class="gps-section-eyebrow wow fadeInUp">Get a Quote</span>
            <h2 class="gps-section-title text-anime-style-3" data-cursor="-opaque">Request a Quote for This Product</h2>
        </div>

        <div class="gps-quote-grid">
            <div class="gps-quote-form-panel">
                <div class="wow fadeInUp">
                    <div class="section-title">
                        <h2 data-cursor="-opaque">Fill in your details</h2>
                    </div>

                    <div class="contact-form">
                        <form action="{{ route('quotations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text"
                                           name="customer_name"
                                           class="form-control"
                                           placeholder="e.g. Adaeze Okoro"
                                           value="{{ old('customer_name') }}"
                                           required>
                                    <div class="form-text text-muted">Enter the name we should address the quote to.</div>
                                    @error('customer_name')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Email Address</label>
                                    <input type="email"
                                           name="customer_email"
                                           class="form-control"
                                           placeholder="e.g. you@company.com"
                                           value="{{ old('customer_email') }}"
                                           required>
                                    <div class="form-text text-muted">We’ll send your quotation and invoice here.</div>
                                    @error('customer_email')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel"
                                           name="customer_phone"
                                           class="form-control"
                                           placeholder="e.g. +234 801 234 5678"
                                           value="{{ old('customer_phone') }}">
                                    <div class="form-text text-muted">Optional, for quick follow‑up.</div>
                                    @error('customer_phone')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Company Name</label>
                                    <input type="text"
                                           name="customer_company"
                                           class="form-control"
                                           placeholder="e.g. Good Procurement Service Ltd"
                                           value="{{ old('customer_company') }}">
                                    <div class="form-text text-muted">Optional, helps us tailor terms.</div>
                                    @error('customer_company')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Quantity Needed</label>
                                    <input type="number"
                                           name="quantity"
                                           class="form-control"
                                           placeholder="e.g. 25 units"
                                           value="{{ old('quantity', 1) }}"
                                           min="1"
                                           required>
                                    <div class="form-text text-muted">Tell us how many units you want us to quote.</div>
                                    @error('quantity')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Subject</label>
                                    <input type="text"
                                           name="subject"
                                           class="form-control"
                                           placeholder="e.g. Quote request for bulk order"
                                           value="{{ old('subject', 'Quote Request for ' . $product->name) }}">
                                    <div class="form-text text-muted">A short title for this request.</div>
                                    @error('subject')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <label class="form-label">Specifications / Requirements</label>
                                    <textarea name="specifications"
                                              class="form-control"
                                              rows="5"
                                              placeholder="e.g. size, material, preferred delivery date, packaging, certifications">{{ old('specifications') }}</textarea>
                                    <div class="form-text text-muted">Share any details that affect pricing or delivery.</div>
                                    @error('specifications')
                                        <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-btn">
                                        <button type="submit" class="btn-default"><span>Request Quote</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="gps-quote-info-panel wow fadeInUp" data-wow-delay="0.2s">
                @if($product->featured_image)
                    <div class="gps-quote-info-image">
                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}">
                    </div>
                @endif

                <h3 class="gps-quote-info-title">{{ $product->name }}</h3>

                @if($product->short_description)
                    <p class="gps-quote-info-desc">{{ $product->short_description }}</p>
                @endif

                <div class="gps-quote-details">
                    @if($product->price > 0)
                        <div class="gps-quote-detail">
                            <div class="gps-quote-detail-icon">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <div>
                                <p class="gps-quote-detail-label">Base Price</p>
                                <p class="gps-quote-detail-value">{{ $product->currency ?? 'NGN' }} {{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endif

                    @if($product->sku)
                        <div class="gps-quote-detail">
                            <div class="gps-quote-detail-icon">
                                <i class="fa-solid fa-barcode"></i>
                            </div>
                            <div>
                                <p class="gps-quote-detail-label">SKU</p>
                                <p class="gps-quote-detail-value">{{ $product->sku }}</p>
                            </div>
                        </div>
                    @endif

                    @if($product->category)
                        <div class="gps-quote-detail">
                            <div class="gps-quote-detail-icon">
                                <i class="fa-solid fa-folder"></i>
                            </div>
                            <div>
                                <p class="gps-quote-detail-label">Category</p>
                                <p class="gps-quote-detail-value">{{ $product->category->name }}</p>
                            </div>
                        </div>
                    @endif

                    @if($product->stock_status)
                        <div class="gps-quote-detail">
                            <div class="gps-quote-detail-icon">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div>
                                <p class="gps-quote-detail-label">Availability</p>
                                <p class="gps-quote-detail-value">{{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Related Products --}}
@if($product && $product->category)
    @php
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with('productPage')
            ->limit(4)
            ->get();
    @endphp

    @if($relatedProducts->count() > 0)
        <div class="gps-related-section">
            <div class="container">
                <div class="gps-section-head gps-center">
                    <span class="gps-section-eyebrow wow fadeInUp">Explore More</span>
                    <h2 class="gps-section-title text-anime-style-3" data-cursor="-opaque">Related Products</h2>
                </div>

                <div class="gps-related-scroll">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="gps-related-card wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                            @if($relatedProduct->featured_image)
                                <div class="gps-related-image">
                                    <img src="{{ asset($relatedProduct->featured_image) }}" alt="{{ $relatedProduct->name }}">
                                </div>
                            @endif

                            <div class="gps-related-content">
                                <h3>{{ $relatedProduct->name }}</h3>
                                @if($relatedProduct->short_description)
                                    <p>{{ Str::limit($relatedProduct->short_description, 80) }}</p>
                                @endif
                                @if($relatedProduct->productPage && $relatedProduct->productPage->is_published)
                                    <a href="{{ route('products.show', $relatedProduct->productPage->slug) }}" class="btn-default">
                                        View Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif

@endsection

@push('styles')
<style>
    /* ===== Page Builder Block Spacing ===== */
    .page-builder-blocks .page-block {
        padding: 90px 0;
        position: relative;
    }

    @media (max-width: 991px) {
        .page-builder-blocks .page-block {
            padding: 60px 0;
        }
    }
</style>
@endpush
