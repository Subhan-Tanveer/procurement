@extends('site.master_layout')

@section('title', 'Services')
@section('description', 'Explore procurement service categories offered by Good Procurement Service Ltd, from Oil & Gas to Corporate and Construction sourcing.')

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-services.css') }}">
@endpush

@section('main')
    <!-- Page Header Section Start -->
    <div class="page-header bg-section parallaxie gps-services-header">
        <video class="gps-hero-video" autoplay muted loop playsinline preload="none" aria-hidden="true">
            <source src="{{ asset('site/assets/videos/hero-services.mp4') }}" type="video/mp4">
        </video>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box gps-page-header-box">
                        <span class="gps-eyebrow wow fadeInUp">What we do</span>
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Our services</h1>
                        <p class="gps-header-lede wow fadeInUp" data-wow-delay="0.2s">Six procurement disciplines under one accountable roof &mdash; sourced, vetted, and delivered on schedule across Oil &amp; Gas, Construction, Maritime, and Corporate sectors.</p>
                        <nav class="wow fadeInUp" data-wow-delay="0.3s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">services</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    @php
        $resolveImage = function ($path, $slug = null) {
            if (!$path) {
                $fallback = $slug ? "site/assets/images/service-{$slug}.jpg" : 'site/assets/images/service-1.jpg';
                return file_exists(public_path($fallback)) ? asset($fallback) : asset('site/assets/images/service-1.jpg');
            }
            if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) {
                return $path;
            }
            if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) {
                return asset('storage/' . $path);
            }
            return asset($path);
        };
    @endphp

    @if($services->count() > 0)
    <!-- Services Marquee Ticker Start -->
    <div class="gps-marquee" aria-hidden="true">
        <div class="gps-marquee-track">
            @for ($i = 0; $i < 2; $i++)
                @foreach($services as $tickerService)
                    <span>{{ $tickerService->name }}</span>
                @endforeach
            @endfor
        </div>
    </div>
    <!-- Services Marquee Ticker End -->
    @endif

    <!-- Page Services Start -->
    <div class="gps-services-listing">
        <div class="container">
            @forelse($services as $index => $service)
                @php
                    $serviceImage = $resolveImage($service->image, $service->slug);
                @endphp
                <!-- Service Row Start -->
                <div class="gps-service-row wow fadeInUp" data-wow-delay="{{ 0.1 * ($index % 6) }}s">
                    <div class="gps-service-row-index" aria-hidden="true">{{ sprintf('%02d', $index + 1) }}</div>

                    <div class="gps-service-row-media">
                        <a href="{{ route('services.show', $service->slug) }}" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{ $serviceImage }}" alt="{{ $service->name }}">
                            </figure>
                        </a>
                    </div>

                    <div class="gps-service-row-body">
                        <div class="gps-service-row-icon">
                            <i class="{{ $service->icon ?: 'fa-solid fa-briefcase' }}" aria-hidden="true"></i>
                        </div>
                        <h3><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></h3>
                        <p>{{ $service->short_description }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="gps-service-row-link">
                            View Details <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <!-- Service Row End -->
            @empty
                <div class="alert alert-info">No services available yet.</div>
            @endforelse
        </div>
    </div>
    <!-- Page Services End -->

    <!-- Interactive Process Layout Start -->
    <div class="interactive interactive-process-layout bg-section">
        <!-- Interactive Process Wrapper Start -->
        <div class="interactive-interactive-process-wrapper interactive-wrapper">
            <div class="interactive-con">
                <!-- Interactive Inner Grid Start -->
                <div class="interactive-con-inner interactive-grid">
                    <!-- Interactive Process Item Start -->
                    <div class="interactive-process-item">
                        <div class="interactive-inner-process activate" data-index="0">
                            <div class="process-content-wap">
                                <div class="interactive-process-item-wap">
                                    <div class="icon-box">
                                        <img src="{{ asset('site/assets/images/icon-interactive-process-item-1.svg') }}" alt="">
                                    </div>
                                    <div class="interactive-process-item-content-wap">
                                        <h3><a href="#">Reliable Procurement Every Time</a></h3>
                                        <p>Ensuring quality materials reach you on schedule and within budget.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Interactive Process Item End -->

                    <!-- Interactive Process Item Start -->
                    <div class="interactive-process-item">
                        <div class="interactive-inner-process" data-index="1">
                            <div class="process-content-wap">
                                <div class="interactive-process-item-wap">
                                    <div class="icon-box">
                                        <img src="{{ asset('site/assets/images/icon-interactive-process-item-2.svg') }}" alt="">
                                    </div>
                                    <div class="interactive-process-item-content-wap">
                                        <h3><a href="#">Global Network Coverage</a></h3>
                                        <p>Access to trusted suppliers and manufacturers worldwide for your procurement needs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Interactive Process Item End -->

                    <!-- Interactive Process Item Start -->
                    <div class="interactive-process-item">
                        <div class="interactive-inner-process" data-index="2">
                            <div class="process-content-wap">
                                <div class="interactive-process-item-wap">
                                    <div class="icon-box">
                                        <img src="{{ asset('site/assets/images/icon-interactive-process-item-3.svg') }}" alt="">
                                    </div>
                                    <div class="interactive-process-item-content-wap">
                                        <h3><a href="#">Competitive Pricing Plans</a></h3>
                                        <p>Cost-effective solutions tailored to your budget without compromising quality.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Interactive Process Item End -->

                    <!-- Interactive Process Item Start -->
                    <div class="interactive-process-item">
                        <div class="interactive-inner-process" data-index="3">
                            <div class="process-content-wap">
                                <div class="interactive-process-item-wap">
                                    <div class="icon-box">
                                        <img src="{{ asset('site/assets/images/icon-interactive-process-item-4.svg') }}" alt="">
                                    </div>
                                    <div class="interactive-process-item-content-wap">
                                        <h3><a href="#">24/7 Customer Support</a></h3>
                                        <p>Our procurement specialists are always available to assist with your requirements.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Interactive Process Item End -->
                </div>
                <!-- Interactive Inner Grid End -->

                <!-- Interactive Process Image Start -->
                <div class="interactive-process-list-image">
                    <div class="interactive-process-image img-0 show" data-bg="{{ asset('site/assets/images/interactive-process-image-1.jpg') }}" style="background-image: url('{{ asset('site/assets/images/interactive-process-image-1.jpg') }}?v={{ filemtime(public_path('site/assets/images/interactive-process-image-1.jpg')) }}');"></div>
                    <div class="interactive-process-image img-1" data-bg="{{ asset('site/assets/images/interactive-process-image-2.jpg') }}" style="background-image: url('{{ asset('site/assets/images/interactive-process-image-2.jpg') }}');"></div>
                    <div class="interactive-process-image img-2" data-bg="{{ asset('site/assets/images/interactive-process-image-3.jpg') }}" style="background-image: url('{{ asset('site/assets/images/interactive-process-image-3.jpg') }}?v={{ filemtime(public_path('site/assets/images/interactive-process-image-3.jpg')) }}');"></div>
                    <div class="interactive-process-image img-3" data-bg="{{ asset('site/assets/images/interactive-process-image-4.jpg') }}" style="background-image: url('{{ asset('site/assets/images/interactive-process-image-4.jpg') }}');"></div>
                </div>
                <!-- Interactive Process Image End -->
            </div>
        </div>
        <!-- Interactive Process Wrapper End -->
    </div>
    <!-- Interactive Process Layout End -->

    <!-- Our Partner Section Start -->
    <div class="our-partner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="our-partner-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">world wide</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Your trusted partner for global logistics excellence</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We specialize in delivering comprehensive transportation and logistics solutions businesses can rely on. With a global network, advanced tracking systems.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Partner Contact Info List Start -->
                        <div class="partner-contact-info-list wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Partner Info Item Start -->
                            <div class="partner-contact-info-item">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('site/assets/images/icon-phone-white.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Partner Contact Info Content Start -->
                                <div class="partner-contact-info-content">
                                    <p>Need help? 24/7</p>
                                    <h3><a href="tel:+2348168363332">+234 816 836 3332</a></h3>
                                </div>
                                <!-- Partner Contact Info Content End -->
                            </div>
                            <!-- Partner Info Item End -->

                            <!-- Partner Info Item Start -->
                            <div class="partner-contact-info-item">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('site/assets/images/icon-mail-white.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Partner Contact Info Content Start -->
                                <div class="partner-contact-info-content">
                                    <p>E-mail us</p>
                                    <h3><a href="mailto:info@example.com">info@example.com</a></h3>
                                </div>
                                <!-- Partner Contact Info Content End -->
                            </div>
                            <!-- Partner Info Item End -->

                            <!-- Partner Info Item Start -->
                            <div class="partner-contact-info-item location-info-item">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('site/assets/images/icon-location-white.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Partner Contact Info Content Start -->
                                <div class="partner-contact-info-content">
                                    <p>Our Locations / Visit us</p>
                                    <h3>1234 Logistics Avenue, Suite 567, Transport City, USA</h3>
                                </div>
                                <!-- Partner Contact Info Content End -->
                            </div>
                            <!-- Partner Info Item End -->
                        </div>
                        <!-- Partner Contact Info List End -->
                    </div>
                </div>

                <div class="col-xl-6">
                    <!-- Partner World Map Box Start -->
                    <div class="partner-world-map-box wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Partner World Map Image Start -->
                        <div class="partner-world-map-image">
                            <figure>
                                <img src="{{ asset('site/assets/images/world-map-image.png') }}" alt="">
                            </figure>
                        </div>
                        <!-- Partner World Map Image End -->

                        <!-- World Map Cards Box Start -->
                        <div class="world-map-cards-box">
                            <!-- World Map Card Item Start -->
                            <div class="world-map-card-item card-1">
                                <!-- World Map Card Button Start -->
                                <button class="world-map-card-btn">
                                    <img src="{{ asset('site/assets/images/icon-location-accent.svg') }}" alt="">
                                </button>
                                <!-- World Map Card Button End -->

                                <!-- World Map Card Body Start -->
                                <div class="world-map-card-body">
                                    <div class="world-map-card-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/world-map-card-image-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="world-map-card-content">
                                        <h3>New York,USA</h3>
                                        <p>Major hub for North American</p>
                                    </div>
                                </div>
                                <!-- World Map Card Body End -->
                            </div>
                            <!-- World Map Card Item End -->

                            <!-- World Map Card Item Start -->
                            <div class="world-map-card-item card-2">
                                <!-- World Map Card Button Start -->
                                <button class="world-map-card-btn">
                                    <img src="{{ asset('site/assets/images/icon-location-accent.svg') }}" alt="">
                                </button>
                                <!-- World Map Card Button End -->

                                <!-- World Map Card Body Start -->
                                <div class="world-map-card-body">
                                    <div class="world-map-card-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/world-map-card-image-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="world-map-card-content">
                                        <h3>New York,USA</h3>
                                        <p>Major hub for North American</p>
                                    </div>
                                </div>
                                <!-- World Map Card Body End -->
                            </div>
                            <!-- World Map Card Item End -->

                            <!-- World Map Card Item Start -->
                            <div class="world-map-card-item card-3 active">
                                <!-- World Map Card Button Start -->
                                <button class="world-map-card-btn">
                                    <img src="{{ asset('site/assets/images/icon-location-accent.svg') }}" alt="">
                                </button>
                                <!-- World Map Card Button End -->

                                <!-- World Map Card Body Start -->
                                <div class="world-map-card-body">
                                    <div class="world-map-card-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/world-map-card-image-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="world-map-card-content">
                                        <h3>New York,USA</h3>
                                        <p>Major hub for North American</p>
                                    </div>
                                </div>
                                <!-- World Map Card Body End -->
                            </div>
                            <!-- World Map Card Item End -->

                            <!-- World Map Card Item Start -->
                            <div class="world-map-card-item card-4">
                                <!-- World Map Card Button Start -->
                                <button class="world-map-card-btn">
                                    <img src="{{ asset('site/assets/images/icon-location-accent.svg') }}" alt="">
                                </button>
                                <!-- World Map Card Button End -->

                                <!-- World Map Card Body Start -->
                                <div class="world-map-card-body">
                                    <div class="world-map-card-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/world-map-card-image-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="world-map-card-content">
                                        <h3>New York,USA</h3>
                                        <p>Major hub for North American</p>
                                    </div>
                                </div>
                                <!-- World Map Card Body End -->
                            </div>
                            <!-- World Map Card Item End -->
                        </div>
                        <!-- World Map Cards Box End -->
                    </div>
                    <!-- Partner World Map Box End -->
                </div>

                <div class="col-lg-12">
                    <!-- World Map Counter Box Start -->
                    <div class="world-map-counter-box wow fadeInUp">
                        <!-- World Map Counter Item Start -->
                        <div class="world-map-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('site/assets/images/icon-world-map-counter-1.svg') }}" alt="">
                            </div>
                            <div class="world-map-counter-content">
                                <h2><span class="counter">25</span>+</h2>
                                <p>Years Of Experience</p>
                            </div>
                        </div>
                        <!-- World Map Counter Item End -->

                        <!-- World Map Counter Item Start -->
                        <div class="world-map-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('site/assets/images/icon-world-map-counter-2.svg') }}" alt="">
                            </div>
                            <div class="world-map-counter-content">
                                <h2><span class="counter">99</span>%</h2>
                                <p>On-Time Delivery Rate</p>
                            </div>
                        </div>
                        <!-- World Map Counter Item End -->

                        <!-- World Map Counter Item Start -->
                        <div class="world-map-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('site/assets/images/icon-world-map-counter-3.svg') }}" alt="">
                            </div>
                            <div class="world-map-counter-content">
                                <h2><span class="counter">1</span>k+</h2>
                                <p>Global Partnership</p>
                            </div>
                        </div>
                        <!-- World Map Counter Item End -->

                        <!-- World Map Counter Item Start -->
                        <div class="world-map-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('site/assets/images/icon-world-map-counter-4.svg') }}" alt="">
                            </div>
                            <div class="world-map-counter-content">
                                <h2><span class="counter">50</span>K+</h2>
                                <p>Shipments Delivered</p>
                            </div>
                        </div>
                        <!-- World Map Counter Item End -->

                        <!-- World Map Counter Item Start -->
                        <div class="world-map-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('site/assets/images/icon-world-map-counter-5.svg') }}" alt="">
                            </div>
                            <div class="world-map-counter-content">
                                <h2><span class="counter">24</span>/7</h2>
                                <p>Customer Support</p>
                            </div>
                        </div>
                        <!-- World Map Counter Item End -->
                    </div>
                    <!-- World Map Counter Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Partner Section End -->

    <!-- Our Testimonials Section Start -->
    <div class="our-testimonials bg-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <!-- Testimonial Image Box Start -->
                    <div class="testimonial-image-box wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Testimonial Image Start -->
                        <div class="testimonial-image">
                            <figure class="image-anime">
                                <img src="{{ asset('site/assets/images/testimonial-image.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- Testimonial Image End -->

                        <!-- Happy Customer Box Start -->
                        <div class="happy-customer-box">
                            <!-- Satisfy Client Images Start -->
                            <div class="satisfy-client-images">
                                <div class="satisfy-client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('site/assets/images/author-1.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="satisfy-client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('site/assets/images/author-2.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="satisfy-client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('site/assets/images/author-3.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="satisfy-client-image add-more">
                                    <h3><span class="counter">10</span>k</h3>
                                </div>
                            </div>
                            <!-- Satisfy Client Images End -->

                            <!-- Review Content Start -->
                            <div class="happy-customer-content">
                                <p>Trusted by World Customer</p>
                            </div>
                            <!-- Review Content End -->
                        </div>
                        <!-- Happy Customer Box End -->
                    </div>
                    <!-- Testimonial Image Box End -->
                </div>

                <div class="col-xl-7">
                    <!-- Testimonial Content Box Start -->
                    <div class="testimonial-content-box">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Our Testimonials</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Hear from business we proudly serve worldwide</h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Testimonial Slider Start -->
                        <div class="testimonial-slider">
                            <div class="swiper">
                                <div class="swiper-wrapper" data-cursor-text="Drag">
                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-company-logo">
                                                <img src="{{ asset('site/assets/images/company-logo-1.svg') }}" alt="">
                                            </div>
                                            <div class="testimonial-content">
                                                <p>"Their logistics solutions transformed our supply chain. On-time delivery and real-time tracking have made our operations seamless reliable, efficient, and professional service every time."</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Darlene Robertson</h3>
                                                    <p>Global Trade Inc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-company-logo">
                                                <img src="{{ asset('site/assets/images/company-logo-2.svg') }}" alt="">
                                            </div>
                                            <div class="testimonial-content">
                                                <p>"Their logistics solutions transformed our supply chain. On-time delivery and real-time tracking have made our operations seamless reliable, efficient, and professional service every time."</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Leslie Alexander</h3>
                                                    <p>CEO, Tech Startup</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-company-logo">
                                                <img src="{{ asset('site/assets/images/company-logo-3.svg') }}" alt="">
                                            </div>
                                            <div class="testimonial-content">
                                                <p>"Their logistics solutions transformed our supply chain. On-time delivery and real-time tracking have made our operations seamless reliable, efficient, and professional service every time."</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Courtney Henry</h3>
                                                    <p>Fleet Supervisor</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->
                                </div>
                                <div class="testimonial-pagination"></div>
                            </div>
                        </div>
                        <!-- Testimonial Slider End -->
                    </div>
                    <!-- Testimonial Content Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonials Section End -->

    <!-- Our Faqs Section Start -->
    <div class="our-faqs gps-faq-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <!-- Faqs Content Start -->
                    <div class="faqs-content gps-faq-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">FAQ's</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Answers to your logistics and shipping queries</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Find clear, detailed answers to common questions about our transportation and logistics services, including shipping processes, tracking, pricing.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Faqs Button Start -->
                        <div class="faqs-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="faqs.html" class="btn-default">View all FAQ's</a>
                        </div>
                        <!-- Faqs Button End -->
                    </div>
                    <!-- Faqs Content End -->
                </div>

                <div class="col-xl-6">
                    <!-- FAQ Accordion Start -->
                    <div class="faq-accordion our-faq-accordion gps-faq-accordion" id="accordion">
                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Q1. What types of transportation services do you provide?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    Q2. Are you logistic solution cost-effective for small businesses?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    Q3. Do you handle international shipping & custom clearance?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    Q4. How do you ensure the safety of my cargo?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Q5. Do you offer temperature controll or specialized shipping?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="1s">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    Q6. How can I get a quote for my shipment?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, our logistics solutions are specifically designed to support businesses of all, growing enterprises. We understand that smaller businesses need flexible affordable.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->
                    </div>
                    <!-- FAQ Accordion End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Faqs Section End -->
@endsection
