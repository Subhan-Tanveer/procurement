@extends('site.master_layout')

@section('title', $service->meta_title ?? $service->name)
@section('description', $service->meta_description ?? $service->short_description)

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-services.css') }}">
@endpush

@section('main')
    <!-- Page Header Section Start -->
    <div class="page-header bg-section parallaxie gps-services-header">
        <video class="gps-hero-video" autoplay muted loop playsinline preload="none" aria-hidden="true">
            <source src="{{ asset('site/assets/videos/hero-' . $service->slug . '.mp4') }}" type="video/mp4">
        </video>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box gps-page-header-box">
                        <span class="gps-eyebrow wow fadeInUp">Service Category</span>
                        <h1 class="text-anime-style-3" data-cursor="-opaque">{{ $service->name }}</h1>
                        @if($service->short_description)
                            <p class="gps-header-lede wow fadeInUp" data-wow-delay="0.2s">{{ $service->short_description }}</p>
                        @endif
                        <nav class="wow fadeInUp" data-wow-delay="0.3s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('services') }}">Services</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    <!-- Page Service Single Start -->
    @php
        $resolveImage = function ($path, $slug = null) {
            if (!$path) {
                $fallback = $slug ? "site/assets/images/service-{$slug}.jpg" : null;
                return $fallback && file_exists(public_path($fallback)) ? asset($fallback) : null;
            }
            if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) {
                return $path;
            }
            if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) {
                return asset('storage/' . $path);
            }
            return asset($path);
        };

        $serviceHeroImage = $resolveImage($service->image, $service->slug);

        $whyChooseFeatures = is_array($service->why_choose_features ?? null)
            ? $service->why_choose_features
            : [];
        $whyChooseTheme = $service->why_choose_theme ?? 'dark';
        $serviceIconClass = $service->icon;
    @endphp
    <div class="page-service-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Page Single Sidebar Start -->
                    <div class="page-single-sidebar gps-single-sidebar">
                        <!-- Page Category List Start -->
                        <div class="page-category-list gps-category-list wow fadeInUp">
                            <h3>Core Services</h3>
                            <ul>
                                @foreach($allServices as $svc)
                                    <li class="{{ $svc->id === $service->id ? 'active' : '' }}">
                                        <a href="{{ route('services.show', $svc->slug) }}">{{ $svc->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Page Category List End -->

                        <!-- Sidebar CTA Box Start -->
                        <div class="sidebar-cta-box gps-cta-panel wow fadeInUp" data-wow-delay="0.25s">
                            <!-- Sidebar CTA Content Start -->
                            <div class="sidebar-cta-content gps-cta-panel-content">
                                <span class="gps-cta-eyebrow">Need this sourced?</span>
                                <h3>We're here to support your procurement needs</h3>
                                <p>Committed to making your procurement experience smooth, efficient, and cost-effective.</p>
                            </div>
                            <!-- Sidebar CTA Content End -->

                            <!-- Sidebar CTA Contact Item Start -->
                            <div class="sidebar-cta-contact-item gps-cta-panel-contact">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                <h3><a href="tel:+2348168363332">+234 816 836 3332</a></h3>
                            </div>
                            <!-- Sidebar CTA Contact Item End -->
                        </div>
                        <!-- Sidebar CTA Box End -->
                    </div>
                    <!-- Page Single Sidebar End -->
                </div>

                <div class="col-lg-8">
                    <!-- Service Single Content Start -->
                    <div class="service-single-content">
                        <!-- Page Single Image Start -->
                        @if($serviceHeroImage)
                        <div class="page-single-image">
                            <figure class="image-anime reveal">
                                <img src="{{ $serviceHeroImage }}" alt="{{ $service->name }}">
                            </figure>
                        </div>
                        @endif
                        <!-- Page Single Image End -->

                        <!-- Service Entry Start -->
                        <div class="service-entry gps-service-entry">
                            <div class="gps-service-eyebrow wow fadeInUp">
                                @if($serviceIconClass)
                                    <i class="{{ $serviceIconClass }}" aria-hidden="true"></i>
                                @endif
                                <span>Service Category &mdash; {{ $service->name }}</span>
                            </div>
                            <p class="wow fadeInUp">{{ $service->description }}</p>

                            @if($service->details->count() > 0)
                            <!-- Service Offer Box Start -->
                            <div class="service-offer-box gps-offer-section">
                                <h2 class="text-anime-style-3">What we offer</h2>
                                <p class="wow fadeInUp">{{ $service->short_description }}</p>

                                <!-- Service Offer Item List Start -->
                                <div class="service-offer-item-list gps-offer-list">
                                    @foreach($service->details as $index => $detail)
                                    <!-- Service Offer Item Start -->
                                    <div class="service-offer-item gps-offer-item wow fadeInUp" data-wow-delay="{{ ($index + 1) * 0.2 }}s">
                                        <div class="gps-offer-item-index" aria-hidden="true">{{ sprintf('%02d', $index + 1) }}</div>
                                        <div class="service-offer-item-content">
                                            <h3>{{ $detail->title }}</h3>
                                            <p>{{ $detail->content }}</p>
                                        </div>
                                    </div>
                                    <!-- Service Offer Item End -->
                                    @endforeach
                                </div>
                                <!-- Service Offer Item List End -->
                            </div>
                            <!-- Service Offer Box End -->
                            @endif

                            <!-- Service Why Choose Box Start -->
                            <div class="service-why-choose-box gps-why-choose {{ $whyChooseTheme === 'light' ? 'service-why-choose-light' : '' }}">
                                @if($service->why_choose_title || $service->why_choose_intro)
                                    <div class="service-why-choose-content">
                                        @if($service->why_choose_title)
                                            <h2 class="text-anime-style-3">{{ $service->why_choose_title }}</h2>
                                        @endif
                                        @if($service->why_choose_intro)
                                            <p class="wow fadeInUp">{{ $service->why_choose_intro }}</p>
                                        @endif
                                    </div>
                                @endif

                                @if(count($whyChooseFeatures) > 0)
                                    @foreach($whyChooseFeatures as $index => $feature)
                                        <div class="service-why-choose-content">
                                            <h2 class="text-anime-style-3">{{ $feature['title'] ?? '' }}</h2>
                                            @if(!empty($feature['description']))
                                                <p class="wow fadeInUp">{{ $feature['description'] }}</p>
                                            @endif
                                            @if(!empty($feature['items']) && is_array($feature['items']))
                                                <ul class="wow fadeInUp" data-wow-delay="0.2s">
                                                    @foreach($feature['items'] as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        @if(!empty($feature['image']))
                                            <div class="service-why-choose-image">
                                                <figure class="image-anime">
                                                    <img src="{{ $resolveImage($feature['image']) }}" alt="{{ $feature['title'] ?? '' }}">
                                                </figure>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="service-why-choose-content">
                                        <h2 class="text-anime-style-3">Why choose our {{ strtolower($service->name) }} service</h2>
                                        <p class="wow fadeInUp">Good Procurement Service Ltd provides reliable and comprehensive procurement solutions tailored to your business needs. Our expertise ensures quality, efficiency, and cost-effectiveness in every engagement.</p>
                                        <ul class="wow fadeInUp" data-wow-delay="0.2s">
                                            <li>Extensive supplier network with verified, reliable partners across industries.</li>
                                            <li>Dedicated account managers ensuring personalized attention to your procurement needs.</li>
                                            <li>Competitive pricing through bulk purchasing power and strategic negotiations.</li>
                                            <li>Quality assurance processes that guarantee product standards and specifications.</li>
                                        </ul>
                                    </div>
                                    <div class="service-why-choose-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/service-why-choose-image.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                @endif
                            </div>
                            <!-- Service Why Choose Box End -->
                        </div>
                        <!-- Service Entry End -->

                        @if($relatedProducts->count() > 0)
                        <!-- Related Products Start -->
                        <div class="related-products gps-related-products mt-5">
                            <div class="section-title">
                                <h2 class="text-anime-style-3" data-cursor="-opaque">Related Products</h2>
                            </div>
                            <div class="row">
                                @foreach($relatedProducts as $product)
                                <div class="col-md-6 mb-4">
                                    <div class="card gps-related-card h-100 border-0 shadow-sm">
                                        @if($product->featured_image)
                                        <img src="{{ asset($product->featured_image) }}" class="card-img-top" alt="{{ $product->name }}">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted">{{ Str::limit($product->short_description, 80) }}</p>
                                            @if($product->price > 0)
                                                <p class="fw-bold text-primary">{{ $product->currency ?? '$' }}{{ number_format($product->price, 2) }}</p>
                                            @endif
                                            <a href="{{ route('products.show', $product->productPage->slug ?? $product->slug) }}" class="btn-default">View Product</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Related Products End -->
                        @endif

                        <!-- Page Single FAQs Start -->
                        <div class="page-single-faqs gps-faq-section">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h2 class="text-anime-style-3" data-cursor="-opaque">Frequently asked questions</h2>
                            </div>
                            <!-- Section Title End -->

                            <!-- FAQ Accordion Start -->
                            <div class="faq-accordion gps-faq-accordion" id="accordion">
                                <!-- FAQ Item Start -->
                                <div class="accordion-item wow fadeInUp">
                                    <h2 class="accordion-header" id="heading1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            Q1. How do I request a quote for {{ strtolower($service->name) }}?
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Simply navigate to our products page, select the items you need, and submit a quote request. Our team will respond within 24 hours with a detailed quotation.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item End -->

                                <!-- FAQ Item Start -->
                                <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                                    <h2 class="accordion-header" id="heading2">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Q2. What is the minimum order quantity?
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Minimum order quantities vary by product. We work with businesses of all sizes, from small enterprises to large corporations. Contact us for specific product MOQ details.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item End -->

                                <!-- FAQ Item Start -->
                                <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                                    <h2 class="accordion-header" id="heading3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            Q3. Do you deliver nationwide?
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Yes, we deliver across Nigeria and can arrange international shipping for clients who require it. Our logistics team ensures timely and safe delivery to your specified location.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item End -->

                                <!-- FAQ Item Start -->
                                <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                                    <h2 class="accordion-header" id="heading4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Q4. How do you ensure product quality?
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>We work only with verified suppliers and conduct thorough quality checks before delivery. All products meet industry standards and come with appropriate certifications and warranties.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item End -->

                                <!-- FAQ Item Start -->
                                <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                                    <h2 class="accordion-header" id="heading5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            Q5. What payment methods do you accept?
                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>We accept bank transfers, corporate purchase orders, and various other payment methods. Payment terms can be discussed based on the order size and client relationship.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item End -->
                            </div>
                            <!-- FAQ Accordion End -->
                        </div>
                        <!-- Page Single FAQs End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Service Single End -->
@endsection
