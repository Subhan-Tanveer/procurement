@extends('site.master_layout')

@section('title', $service->meta_title ?? $service->name)
@section('description', $service->meta_description ?? $service->short_description)

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-services.css') }}">
@endpush

@section('main')
    @php
        // Finalized short-form copy per service, mapped to the hero subhead and the
        // "Why Choose" differentiation line so each page shows distinct copy instead
        // of the same generic sentence repeated across zones.
        $servicePlacementCopy = [
            'office-admin-corporate-procurement' => [
                'subhead' => "Running out of the basics shouldn't be why your office slows down.",
                'why_choose_label' => 'Why Choose Our Office & Corporate Procurement',
                'why_choose_copy' => 'One point of contact for everything your office runs on, sourced properly and delivered before you actually need it.',
            ],
            'technology-it-procurement' => [
                'subhead' => "The wrong device or license costs more in workaround hours than it ever saves.",
                'why_choose_label' => 'Why Choose Our Technology & IT Procurement',
                'why_choose_copy' => "We check fitness for purpose before anything ships, not after it's already slowing your team down.",
            ],
            'construction-infrastructure-procurement' => [
                'subhead' => "Materials that don't match spec look fine, until they're already installed.",
                'why_choose_label' => 'Why Choose Our Construction & Infrastructure Procurement',
                'why_choose_copy' => 'We source to spec and coordinate delivery around your actual site timeline, not a generic one.',
            ],
            'oil-gas-procurement' => [
                'subhead' => "On this kind of operation, the wrong consumable isn't a small problem.",
                'why_choose_label' => 'Why Choose Our Oil & Gas Procurement',
                'why_choose_copy' => 'Safety materials and technical equipment sourced with the seriousness the category actually requires, not just the lowest quote.',
            ],
            'maritime-supply' => [
                'subhead' => "A vessel that isn't ready when your operation needs it delays everything scheduled after it.",
                'why_choose_label' => 'Why Choose Our Maritime Supply',
                'why_choose_copy' => 'We vet for real availability and fitness for the job, not just whether a vessel exists on paper.',
            ],
            'site-camp-welfare-supplies' => [
                'subhead' => 'Working away from home is hard enough without going without the basics.',
                'why_choose_label' => 'Why Choose Our Site & Camp Welfare Supplies',
                'why_choose_copy' => 'Quality checked before it ships, so your crew rests and comes back ready, not worn down.',
            ],
        ][$service->slug] ?? null;
    @endphp
    <!-- Page Header Section Start -->
    <div class="page-header bg-section parallaxie gps-services-header gps-services-header--{{ $service->slug }}">
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
                        @if($servicePlacementCopy['subhead'] ?? $service->short_description)
                            <p class="gps-header-lede wow fadeInUp" data-wow-delay="0.2s">{{ $servicePlacementCopy['subhead'] ?? $service->short_description }}</p>
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
                                <span class="gps-cta-eyebrow">Need This Moved Too?</span>
                                <h3>Logistics & Fleet Support</h3>
                                <p>Runs underneath every category. Vehicles, heavy-duty equipment, customs clearing, and expediting, available on request.</p>
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
                                        <h2 class="text-anime-style-3">{{ $servicePlacementCopy['why_choose_label'] ?? 'Why choose our ' . strtolower($service->name) . ' service' }}</h2>
                                        <p class="wow fadeInUp">{{ $servicePlacementCopy['why_choose_copy'] ?? 'Good Procurement Service Ltd provides reliable and comprehensive procurement solutions tailored to your business needs. Our expertise ensures quality, efficiency, and cost-effectiveness in every engagement.' }}</p>
                                    </div>
                                    <div class="service-why-choose-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('site/assets/images/service-why-choose-image.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                @endif
                            </div>
                            <!-- Service Why Choose Box End -->

                            @if($service->details->count() > 0)
                            <!-- Service Offer Box Start -->
                            <div class="service-offer-box gps-offer-section">
                                <h2 class="text-anime-style-3">What we offer</h2>

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
                        </div>
                        <!-- Service Entry End -->

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
